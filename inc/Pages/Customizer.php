<?php

namespace PerkoCustomizerUI\Pages;

use PerkoCustomizerUI\Classes\CustomizerControl;
use PerkoCustomizerUI\Classes\CustomizerSection;
use PerkoCustomizerUI\Services\CustomizerGenerator;
use PerkoCustomizerUI\Services\DataService;

/**
 * Class Customizer
 * @package PerkoCustomizerUI\Pages
 *
 * This file is used by the customizer page.  It will load all
 * of the data for the fields and sections, and pass it off to
 * the CustomizerGenerator to register the customizer settings,
 * sections, and controls.
 */
class Customizer {

	public $customizer_fields = [];
	public $customizer_sections = [];

	public function register() {
		add_action( 'customize_register', [ $this, 'registerCustomizerFields' ] );
	}

	function registerCustomizerFields( $wp_customize ) {
		$this->loadData();

		if ( ! empty( $this->customizer_fields ) && ! empty( $this->customizer_sections ) ) {
			CustomizerGenerator::Generate( $wp_customize, $this->customizer_sections );
		}
	}

	private function loadData() {
		$settings = DataService::getSettings()['sections'];

		foreach ( $settings as $sectionKey => $section ) {

			$sectionControls = [];
			foreach ( $section['controls'] as $control ) {
				$customizerControl = new CustomizerControl(
					$control['control_id'],
					$control['control_label'],
					$control['control_id'],
					$control['section'],
					$control['control_type'],
					$control['control_default'],
					$control['control_choices'] );

				$this->customizer_fields[] = $customizerControl;
				$sectionControls[] = $customizerControl;
			}


			$id = strtolower( $section['section_title'] );
			$id = str_replace( ' ', '_', $id );

			$this->customizer_sections[] = new CustomizerSection( $id, $section['section_title'], 99, $sectionControls );
		}
	}
}