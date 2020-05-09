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

		// delete a section
		if ( isset( $_POST['remove'] ) ) {
			$sectionName = $_POST['remove'];

			return DataService::deleteSection( $settings, $sectionName );
		}

		// edit a section name
		if ( isset( $_POST['edit_section'] ) ) {
			$id = DataService::getSectionIdByName( $_POST['old_title'] );

			$error = self::validateSectionName( $_POST['new_title'] );
			if ( $error ) {
				add_settings_error( 'wpcui_sections', null, $error );

				return $settings;
			}
			$settings[ $id ]['section_title'] = $_POST['new_title'];

			return $settings;
		}

		$error = self::validateSectionName( $input['section_title'] );
		if ( $error ) {
			add_settings_error( 'wpcui_sections', null, $error );

			return $settings;
		}

		// create a new section
		$id              = DataService::getNextSectionId();
		$settings[ $id ] = $input;
		DataService::updateNextSectionId();

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
		$sectionId        = $_POST['section'];
		$input['section'] = $sectionId;
		$output           = DataService::getControls();

		// lowercase the id
		$input['control_id'] = strtolower( $input['control_id'] );

		$error = self::validateControlId( $input['control_id'] );
		if ( $error ) {
			add_settings_error( 'control_id', null, $error );

			return $output;
		}

		if ( isset( $_POST['remove'] ) ) {
			unset( $output[ $_POST['remove'] ] );

			return $output;
		}

		$new_input = [ $input['control_id'] => $input ];

		if ( count( $output ) == 0 ) {
			$output = $new_input;

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

			/*
			 * Clean up the database.  if the control's section no longer exists,
			 * delete it.
			 */
			if ( ! array_key_exists( $value['section'], DataService::getSections() ) ) {
				unset( $output[ $key ] );
			}

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

		foreach ( DataService::getControls() as $key => $control ) {
			if ( $key == $id ) {
				return "Control ID $id already exists.";
			}
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