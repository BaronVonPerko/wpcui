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
        $output = DataService::getSections();

        // delete a section
        if ( isset( $_POST['remove'] ) ) {
        	$sectionName = $_POST['remove'];

			$id = DataService::getSectionIdByName($sectionName);

	        unset( $output[$id] );

	        return $output;
        }

        // edit a section name
        if ( isset( $_POST['edit_section'] ) ) {
        	$id = DataService::getSectionIdByName($_POST['old_title']);
            $output[$id]['section_title'] = $_POST['new_title'];
            return $output;
        }

        // create a new section
	    $id = DataService::getNextSectionId();
        $output[$id] = $input;
        DataService::updateNextSectionId();

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
		$sectionId = $_POST['section'];
		$input['section'] = $sectionId;
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

			/*
			 * Clean up the database.  if the control's section no longer exists,
			 * delete it.
			 */
			if(!array_key_exists($value['section'], DataService::getSections())) {
				unset($output[$key]);
			}

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


}