<?php

namespace PerkoCustomizerUI\Services;

use PerkoCustomizerUI\Classes\CustomizerControl;
use PerkoCustomizerUI\Data\DataService;
use PerkoCustomizerUI\Forms\AdminPageFormActions;

/**
 * Class AdminSanitizerService
 * @package PerkoCustomizerUI\Services
 *
 * Service for sanitizing form requests from the Admin page
 */
class AdminSanitizerService {

	/**
	 * Sanitization handler for saving the sections form.
	 *
	 * @param $input
	 *
	 * @return array|mixed|void
	 */
	public function sanitizeSettings( $input ): array {
		$settings = DataService::getSettings();

		if ( array_key_exists( 'wpcui_action', $_POST ) ) {
			switch ( sanitize_text_field( $_POST['wpcui_action'] ) ) {
				case AdminPageFormActions::CreateNewSection:
					$settings = $this->sanitizeNewSection( $input, $settings );
					break;
				case AdminPageFormActions::UpdateSection:
					$settings = $this->sanitizeUpdateSectionName( $settings );
					break;
				case AdminPageFormActions::DuplicateSection:
					$settings = $this->sanitizeDuplicateSection( $settings );
					break;
				case AdminPageFormActions::DeleteSection:
					$settings = $this->sanitizeDeleteSection( $settings );
					break;
				case AdminPageFormActions::CreateControl:
					$settings = $this->sanitizeNewControl( $input, $settings );
					break;
				case AdminPageFormActions::UpdateControl:
					$settings = $this->sanitizeUpdateControl( $input, $settings );
					break;
				case AdminPageFormActions::DeleteControl:
					$settings = $this->sanitizeDeleteControl( $settings );
					break;
			}
		}

		return $settings;
	}

	/**
	 * @param $input
	 * @param $settings
	 *
	 * @return mixed
	 */
	private function sanitizeNewSection( $input, $settings ) {
		$title = sanitize_text_field( $input['section_title'] );
		$error = self::validateSectionName( $title );
		if ( $error ) {
			add_settings_error( 'wpcui_sections', null, $error );

			return $settings;
		}

		DataService::createNewSection( $settings, $title );

		return $settings;
	}

	/**
	 * @param $settings
	 *
	 * @return mixed
	 */
	private function sanitizeUpdateSectionName( $settings ) {
		if ( AdminFormStatusService::IsCancel() ) {
			add_settings_error( 'wpcui_sections', null, "No changes were made.", 'info' );

			return $settings;
		}

		$id       = sanitize_text_field( $_POST['section_id'] );
		$newTitle = sanitize_text_field( $_POST['new_title'] );

		$error = self::validateSectionName( $newTitle );
		if ( $error ) {
			add_settings_error( 'wpcui_sections', null, $error );

			return $settings;
		}
		$settings['sections'][ $id ]->title = $newTitle;

		return $settings;
	}

	/**
	 * @param $settings
	 *
	 * @return mixed
	 */
	private function sanitizeDuplicateSection( $settings ) {
		$sectionId  = sanitize_text_field( $_POST['section_id'] );
		$section    = DataService::getSections()[ $sectionId ];
		$newSection = DataService::duplicateSection( $section );

		DataService::insertNewSection( $settings, $newSection );

		return $settings;
	}

	/**
	 * @param $settings
	 *
	 * @return mixed
	 */
	private function sanitizeDeleteSection( $settings ) {
		if ( isset( $_POST['section_id'] ) ) {
			$sectionId = sanitize_text_field( $_POST['section_id'] );

			unset( $settings['sections'][ $sectionId ] );
		}

		return $settings;
	}

	/**
	 * @param $input
	 * @param $settings
	 *
	 * @return mixed
	 */
	private function sanitizeNewControl( $input, $settings ) {
		$controlId = DataService::convertStringToId( $input['control_id'] );
		$sectionId = sanitize_text_field( $_POST['section'] );
		$error     = self::validateControlId( $controlId );

		if ( $error ) {
			add_settings_error( 'control_id', null, $error );

			return $settings;
		}

		$control = new CustomizerControl(
			sanitize_text_field( $input['control_id'] ),
			sanitize_text_field( $input['control_label'] ),
			sanitize_text_field( $input['control_type'] ),
			sanitize_text_field( $input['control_default'] ),
			sanitize_text_field( $input['control_choices'] )
		);

		$settings['sections'][ $sectionId ]->controls[ $controlId ] = $control;

		return $settings;
	}

	/**
	 * @param $input
	 * @param $settings
	 *
	 * @return mixed
	 */
	private function sanitizeUpdateControl( $input, $settings ) {
		if ( AdminFormStatusService::IsCancel() ) {
			add_settings_error( 'wpcui_sections', null, "No changes were made.", 'info' );

			return $settings;
		}

		$oldControlId = sanitize_text_field( $_POST['old_control_id'] );

		foreach ( $settings['sections'] as $section ) {
			foreach ( $section->controls as $control ) {
				if ( $control->id == $oldControlId ) {
					$controlId = sanitize_text_field( $input['control_id'] );

					$control = new CustomizerControl(
						sanitize_text_field( $input['control_id'] ),
						sanitize_text_field( $input['control_label'] ),
						sanitize_text_field( $input['control_type'] ),
						sanitize_text_field( $input['control_default'] ),
						sanitize_text_field( $input['control_choices'] )
					);

					if ( $controlId != $oldControlId ) {
						unset( $settings['sections'][ $section->id ]->controls[ $oldControlId ] );
					}

					$settings['sections'][ $section->id ]->controls[ $controlId ] = $control;
				}
			}
		}

		return $settings;
	}

	/**
	 * @param $settings
	 *
	 * @return mixed
	 */
	private function sanitizeDeleteControl( $settings ) {
		if ( isset( $_POST['control_id'] ) ) {
			$controlId = sanitize_text_field( $_POST['control_id'] );
			foreach ( $settings['sections'] as $section ) {
				foreach ( $section->controls as $control ) {
					if ( $control->id == $controlId ) {
						unset( $settings['sections'][ $section->id ]->controls[ $controlId ] );
					}
				}
			}
		}

		return $settings;
	}

	/**
	 * Validate to make sure that the control ID meets the requirements
	 * of the WP Customizer.
	 *
	 * @param $id
	 *
	 * @return bool|string
	 */
	public function validateControlId( $id ) {
		if ( strpos( $id, ' ' ) ) {
			return 'Control ID must not contain spaces.';
		}

		if ( strpos( $id, '-' ) ) {
			return 'Control ID must not contain hyphens.  Use underscores instead.';
		}

		if ( DataService::checkControlIdExists( $id ) ) {
			return "Control ID $id already exists.";
		}

		return false;
	}


	/**
	 * Validate to make sure that the section name is unique.
	 *
	 * @param $sectionName
	 *
	 * @return bool|string
	 */
	public function validateSectionName( $sectionName ) {
		return DataService::checkSectionExists( $sectionName )
			? "A section with this name already exists."
			: false;
	}
}