<?php

namespace Inc\Services;

class AdminSanitizerService{
    public function sanitize( $input ) {
        $output = get_option( 'wpcui_sections' );

        if ( isset( $_POST['remove'] ) ) {
            return $this->deleteSection($_POST['remove']);
        }

        if ( isset( $_POST['edit'] ) ) {
            return $output;
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

        // todo: need to remove the unused controls from the database.
        // for some reason, update_option is not working here...

        return $sections;
    }

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

        foreach ( $output as $key => $value ) {
            if ( $input['control_id'] === $key ) {
                $output[ $key ] = $input;
            } else {
                $output[ $input['control_id'] ] = $input;
            }
        }

        return $output;
    }
}