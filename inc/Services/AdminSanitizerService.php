<?php

namespace PerkoCustomizerUI\Services;

use PerkoCustomizerUI\Classes\CustomizerControl;
use PerkoCustomizerUI\Data\DataService;
use PerkoCustomizerUI\Data\DataValidators;
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
	 * Sanitization when a new section is created.
	 *
	 * @param $input
	 * @param $settings
	 *
	 * @return mixed
	 */
	private function sanitizeNewSection( $input, $settings ) {
		$title = sanitize_text_field( $input['section_title'] );
		$error = DataValidators::validateSectionName( $title );

		if ( $error ) {
			add_settings_error( 'wpcui_sections', null, $error );

			return $settings;
		}

		DataService::createNewSection( $settings, $title );

		return $settings;
	}

	/**
	 * Sanitization when a section name is updated.
	 *
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

		$error = DataValidators::validateSectionName( $newTitle );
		if ( $error ) {
			add_settings_error( 'wpcui_sections', null, $error );

			return $settings;
		}
		$settings['sections'][ $id ]->title = $newTitle;

		return $settings;
	}

	/**
	 * Sanitize when a section is duplicated.
	 *
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
	 * Sanitize when a section is deleted.
	 *
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
	 * Sanitize when a new control is created.
	 *
	 * @param $input
	 * @param $settings
	 *
	 * @return mixed
	 */
	private function sanitizeNewControl( $input, $settings ) {
		$controlId = DataService::convertStringToId( $input['control_id'] );
		$sectionId = sanitize_text_field( $_POST['section'] );
		$error     = DataValidators::validateControlId( $controlId );

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
	 * Sanitize when a control is updated.
	 *
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
	 * Sanitize when a control is deleted.
	 *
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
}
