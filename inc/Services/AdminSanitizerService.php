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
	 * Sanitization handler for saving the sections form
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
			}
		}

		return $settings;
	}

	private function sanitizeNewSection( $input, $settings ) {
		$error = self::validateSectionName( $input['section_title'] );
		if ( $error ) {
			add_settings_error( 'wpcui_sections', null, $error );

			return $settings;
		}

		// create a new section
		$id                          = DataService::getNextSectionId();
		$settings[ $id ]             = $input;
		$settings[ $id ]['controls'] = [];
		DataService::updateNextSectionId();

		return $settings;
	}

	private function sanitizeUpdateSectionName( $settings ) {
		if ( isset( $_POST['edit_section'] ) ) {
			$id = DataService::getSectionIdByName( $_POST['old_title'] );

			$error = self::validateSectionName( $_POST['new_title'] );
			if ( $error ) {
				add_settings_error( 'wpcui_sections', null, $error );

				return $settings;
			}
			$settings[ $id ]['section_title'] = $_POST['new_title'];
		}

		return $settings;
	}

	private function sanitizeDeleteSection( $settings ) {
		if ( isset( $_POST['remove'] ) ) {
			$sectionName = $_POST['remove'];

			$settings = DataService::deleteSection( $settings, $sectionName );
		}

		return $settings;
	}

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

		$settings[ $sectionId ]['controls'][ $controlId ] = $input;

		return $settings;
	}

	/**
	 * Sanitization handler for saving the control form
	 *
	 * @param $input
	 *
	 * @return array|mixed|void
	 */
	public function sanitizeControl( $input ) {
		if ( isset( $_POST['remove'] ) ) {
			unset( $output[ $_POST['remove'] ] );

			return $output;
		}


		// format the choices if there are any
		if ( array_key_exists( 'control_choices', $input ) ) {
			$choices     = explode( ',', $input['control_choices'] );
			$new_choices = [];
			foreach ( $choices as $choice ) {
				$new_choices[ $choice ] = $choice;
			}
			$input['control_choices'] = $new_choices;
		}

		foreach ( $output as $key => $value ) {

			// update existing value
			if ( $input['control_id'] === $key ) {
				$output[ $key ] = $input;
			} // create new entry
			else {
				$output[ $input['control_id'] ] = $input;
			}
		}

		return $output;
	}


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


	public function validateSectionName( $sectionName ) {
		foreach ( DataService::getSettings() as $section ) {
			if ( $section['section_title'] == $sectionName ) {
				return "A section with this name already exists.";
			}
		}

		return false;
	}
}