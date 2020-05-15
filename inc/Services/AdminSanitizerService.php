<?php

namespace PerkoCustomizerUI\Services;

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
	public function sanitizeSettings( $input ) {
		$settings = DataService::getSettings();

		if ( array_key_exists( 'wpcui_action', $_POST ) ) {
			switch ( $_POST['wpcui_action'] ) {
				case 'create_new_section':
					$settings = $this->sanitizeNewSection( $input, $settings );
					break;
				case 'update_section_title':
					$settings = $this->sanitizeUpdateSectionName( $settings );
					break;
				case 'delete_section':
					$settings = $this->sanitizeDeleteSection( $settings );
					break;
				case 'create_new_control':
					$settings = $this->sanitizeNewControl( $input, $settings );
					break;
				case 'delete_control':
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

		// create a new section
		$id                                      = DataService::getNextSectionId();
		$settings['sections'][ $id ]             = [ "section_title" => $title ];
		$settings['sections'][ $id ]['controls'] = [];
		DataService::updateNextSectionId();

		return $settings;
	}

	/**
	 * @param $settings
	 *
	 * @return mixed
	 */
	private function sanitizeUpdateSectionName( $settings ) {
		if ( isset( $_POST['edit_section'] ) ) {
			$oldTitle = sanitize_text_field($_POST['edit_section']);
			$newTitle = sanitize_text_field($_POST['new_title']);

			$id = DataService::getSectionIdByName( $oldTitle );

			$error = self::validateSectionName( $newTitle );
			if ( $error ) {
				add_settings_error( 'wpcui_sections', null, $error );

				return $settings;
			}
			$settings['sections'][ $id ]['section_title'] = $newTitle;
		}

		return $settings;
	}

	/**
	 * @param $settings
	 *
	 * @return mixed
	 */
	private function sanitizeDeleteSection( $settings ) {
		if ( isset( $_POST['section_title'] ) ) {
			$sectionName = $_POST['section_title'];

			$id = DataService::getSectionIdByName( $sectionName );

			unset( $settings['sections'][ $id ] );
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
		$controlId           = strtolower( $input['control_id'] );
		$sectionId           = $_POST['section'];
		$input['section']    = $sectionId;
		$input['control_id'] = $controlId;
		$error               = self::validateControlId( $controlId );

		if ( $error ) {
			add_settings_error( 'control_id', null, $error );

			return $settings;
		}

		$settings['sections'][ $sectionId ]['controls'][ $controlId ] = $input;

		return $settings;
	}

	/**
	 * @param $settings
	 *
	 * @return mixed
	 */
	private function sanitizeDeleteControl( $settings ) {
		if ( isset( $_POST['control_id'] ) ) {
			$controlId = $_POST['control_id'];
			foreach ( $settings['sections'] as $sectionKey => $section ) {
				foreach ( $section['controls'] as $controlKey => $controlData ) {
					if ( $controlKey == $controlId ) {
						unset( $settings['sections'][ $sectionKey ]['controls'][ $controlId ] );
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
		foreach ( DataService::getSettings()['sections'] as $section ) {
			if ( $section['section_title'] == $sectionName ) {
				return "A section with this name already exists.";
			}
		}

		return false;
	}
}