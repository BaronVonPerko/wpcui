<?php

namespace Inc\Pages;

use Inc\Classes\CustomizerControl;
use Inc\Classes\CustomizerSection;
use Inc\Services\CustomizerGenerator;
use Inc\Services\DataService;

class Customizer{

    public $customizer_fields = [];
    public $customizer_sections = [];

    public function register() {
        $this->loadData();

        if ( ! empty( $this->customizer_fields ) && ! empty( $this->customizer_sections ) ) {
            add_action( 'customize_register', [ $this, 'registerCustomizerFields' ] );
        }
    }

    function registerCustomizerFields( $wp_customize ) {
        CustomizerGenerator::Generate( $wp_customize, $this->customizer_fields, $this->customizer_sections );
    }

    private function loadData() {
        $saved_sections = DataService::getSections();
        $saved_controls = DataService::getControls();

        foreach ($saved_controls as $saved_control) {
            $this->customizer_fields[] = new CustomizerControl($saved_control['control_id'],
                $saved_control['control_label'], $saved_control['control_id'], $saved_control['control_type']);
        }

        foreach ($saved_sections as $key => $saved_section) {

            $section_controls = array_filter($saved_controls, function ($control) use ($key) {
                return $control['section'] == $key;
            });

            $controls = [];
            foreach ($section_controls as $section_control) {
                $controls[] = new CustomizerControl($section_control['control_id'], $section_control['control_label'],
                    $section_control['control_id'], $section_control['control_type']);
            }

            $id = strtolower($saved_section['section_title']);
            $id = str_replace(' ', '_', $id);
            $this->customizer_sections[] = new CustomizerSection($id, $saved_section['section_title'], 99, $controls);
        }
    }
}