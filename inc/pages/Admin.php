<?php

namespace Inc\Pages;

use Inc\Base\BaseController;
use Inc\Classes\CustomizerControl;
use Inc\Classes\CustomizerSection;
use Inc\Classes\CustomizerSetting;
use Inc\Services\CustomizerGenerator;

class Admin extends BaseController {

	public $customizer_fields = [];
	public $customizer_sections = [];

	public function register() {
		$this->getSavedData();

		if ( ! empty( $this->customizer_fields ) && ! empty( $this->customizer_sections ) ) {
			add_action( 'customize_register', [ $this, 'registerCustomizerFields' ] );
		}

		add_action( 'admin_menu', [ $this, 'addAdminPage' ] );

		add_action( 'admin_init', [ $this, 'setSettings' ] );
	}

	function adminIndex() {
		require_once "$this->plugin_path/templates/admin.php";
	}

	function addAdminPage() {
		add_menu_page( 'WPCUI Plugin', 'WPCUI', 'manage_options', 'wpcui', [ $this, 'adminIndex' ],
			'dashicons-admin-customizer', 110 );
	}

	function registerCustomizerFields( $wp_customize ) {
		CustomizerGenerator::Generate( $wp_customize, $this->customizer_fields, $this->customizer_sections );
	}

	public function getSavedData() {
		$this->customizer_fields[]   = new CustomizerSetting( 'name', 'Chris Perko' );
		$controls                    = [];
		$controls[]                  = new CustomizerControl( 'name', 'Your Name', 'name' );
		$this->customizer_sections[] = new CustomizerSection( 'personal_info', 'Personal Info', '99', $controls );
	}

	public function setSettings() {
		register_setting( 'wpcui', 'wpcui_sections', [ $this, 'sanitize' ] );

		add_settings_section( 'wpcui_section_index', 'Add Section', [ $this, 'sectionOutput' ], 'wpcui' );

		add_settings_field( 'section_title',
			'Section Title',
			[ $this, 'textField' ],
			'wpcui',
			'wpcui_section_index',
			[
				'option_name' => 'wpcui_sections',
				'label_for'   => 'section_title',
				'placeholder' => 'eg. Personal Info',
			] );
	}

	public function sanitize( $input ) {
		$output = get_option( 'wpcui_sections' );

		if ( isset( $_POST['remove'] ) ) {
			unset($output[$_POST['remove']]);
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

	public function sectionOutput() {
		echo '<p>Use this form to create a new Customizer section</p>';
	}

	public function textField( $args ) {
		$name        = $args['label_for'];
		$option_name = $args['option_name'];
		$value       = '';

		echo '<input type="text" class="regular-text" id="' . $name . '" name="' . $option_name . '[' . $name . ']" value="' . $value . '" placeholder="' . $args['placeholder'] . '" required>';
	}
}