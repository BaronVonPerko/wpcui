<?php

namespace Inc\Services;

class AdminSanitizerService{

	/**
	 * Sanitization handler for saving the sections form
	 *
	 * @param $input
	 *
	 * @return array|mixed|void
	 */
    public function sanitizeSection( $input ) {
        $output = get_option( 'wpcui_sections' );

        if ( isset( $_POST['remove'] ) ) {
            return $this->deleteSection($_POST['remove']);
        }

        if ( isset( $_POST['edit_section'] ) ) {
            return DataService::updateSectionName($_POST['old_title'], $_POST['new_title'], $output);
        }

        $new_input = [ $input['section_title'] => $input ];

        if ( count( $output ) == 0 ) {
            $output = $new_input;

            return $output;
        }

        foreach ( $output as $key => $value ) {
            if ( $input['section_title'] === $key ) {
                $output[ $key ] = $input;
            } else {
                $output[ $input['section_title'] ] = $input;
            }
        }

        return $output;
    }

	/**
	 * Sanitization handler for saving the control form
	 *
	 * @param $input
	 *
	 * @return array|mixed|void
	 */
	public function sanitizeControl( $input ) {
		$input['section'] = $_POST['section'];
		$output           = DataService::getControls();

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
		if(array_key_exists('control_choices', $input)) {
			$choices = explode(',', $input['control_choices']);
			$new_choices = [];
			foreach ($choices as $choice) {
				$new_choices[$choice] = $choice;
			}
			$input['control_choices'] = $new_choices;
		}

		foreach ( $output as $key => $value ) {
			// update existing value
			if ( $input['control_id'] === $key ) {
				$output[ $key ] = $input;
			}
			// create new entry
			else {
				$output[ $input['control_id'] ] = $input;
			}
		}

		return $output;
	}


	/**
	 * Delete a section
	 *
	 * @param $section_name
	 *
	 * @return mixed|void
	 */
    public function deleteSection($section_name) {
        $sections = DataService::getSections();
        $controls = DataService::getControls();

        unset( $sections[$section_name] );

        $controls_for_section = array_filter($controls, function($control) use ($section_name) {
            return $control['section'] == $section_name;
        });

        foreach($controls_for_section as $key => $control) {
            unset($controls[$key]);
        }

        self::deleteControls($section_name);

        return $sections;
    }


	/**
	 * Delete all of the controls for a given section name
	 *
	 * @param $section_name
	 */
    public function deleteControls($section_name) {
		// filter out the controls associated with this section
		$controls = array_filter(DataService::getControls(), function($control) use ($section_name) {
			return $control['section'] != $section_name;
		});

		DataService::setControls($controls);
    }


}