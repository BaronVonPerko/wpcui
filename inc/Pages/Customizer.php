<?php

namespace PerkoCustomizerUI\Pages;

use PerkoCustomizerUI\Classes\CustomizerControl;
use PerkoCustomizerUI\Classes\CustomizerSection;
use PerkoCustomizerUI\Services\CustomizerGenerator;
use PerkoCustomizerUI\Services\DataService;

class Customizer {

	public $customizer_fields = [];
	public $customizer_sections = [];

	public function register() {
		add_action( 'customize_register', [ $this, 'registerCustomizerFields' ] );
	}

	function registerCustomizerFields( $wp_customize ) {
		$this->loadData();

		if ( ! empty( $this->customizer_fields ) && ! empty( $this->customizer_sections ) ) {
			CustomizerGenerator::Generate( $wp_customize, $this->customizer_fields, $this->customizer_sections );
		}
	}

	private function loadData() {
		$saved_sections = DataService::getSections();
		$saved_controls = DataService::getControls();

		foreach ( $saved_controls as $saved_control ) {
			$this->customizer_fields[] = new CustomizerControl(
				$saved_control['control_id'],
				$saved_control['control_label'],
				$saved_control['control_id'],
				$saved_control['control_type'],
				$saved_control['control_default']
			);
		}

		foreach ( $saved_sections as $key => $saved_section ) {

			$section_controls = array_filter( $saved_controls, function ( $control ) use ( $key ) {
				return $control['section'] == $key;
			} );

			$controls = [];
			foreach ( $section_controls as $section_control ) {
				$controls[] = new CustomizerControl( $section_control['control_id'], $section_control['control_label'],
					$section_control['control_id'], $section_control['control_type'], $section_control['control_choices'] );
			}

			$id                          = strtolower( $saved_section['section_title'] );
			$id                          = str_replace( ' ', '_', $id );
			$this->customizer_sections[] = new CustomizerSection( $id, $saved_section['section_title'], 99, $controls );
		}
	}
}