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
		$saved_sections = get_option( 'wpcui_sections' );
		$saved_controls = get_option( 'wpcui_controls' );

		foreach ( $saved_controls as $saved_control ) {
			$this->customizer_fields[] = new CustomizerControl( $saved_control['control_id'], $saved_control['control_label'], $saved_control['control_id'], $saved_control['control_type'] );
		}

		foreach ( $saved_sections as $key => $saved_section ) {

			$section_controls = array_filter( $saved_controls, function ( $control ) use ( $key ) {
				return $control['section'] == $key;
			} );

			$controls = [];
			foreach ( $section_controls as $section_control ) {
				$controls[] = new CustomizerControl( $section_control['control_id'], $section_control['control_label'], $section_control['control_id'], $section_control['control_type'] );
			}

			$id                          = strtolower( $saved_section['section_title'] );
			$id                          = str_replace( ' ', '_', $id );
			$this->customizer_sections[] = new CustomizerSection( $id, $saved_section['section_title'], 99, $controls );
		}
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


		register_setting( 'wpcui-control', 'wpcui_controls', [ $this, 'sanitizeControl' ] );

		add_settings_section( 'wpcui_section_control', 'Add Control', [ $this, 'controlOutput' ], 'wpcui-control' );

		add_settings_field( 'control_id',
			'Control ID',
			[ $this, 'textField' ],
			'wpcui-control',
			'wpcui_section_control',
			[
				'option_name' => 'wpcui_controls',
				'label_for'   => 'control_id',
				'placeholder' => 'eg. location_info'
			] );

		add_settings_field( 'control_label',
			'Control Label',
			[ $this, 'textField' ],
			'wpcui-control',
			'wpcui_section_control',
			[
				'option_name' => 'wpcui_controls',
				'label_for'   => 'control_label',
				'placeholder' => 'eg. Location Info'
			] );

		add_settings_field( 'control_type',
            'Control Type',
            [ $this, 'dropDown'],
            'wpcui-control',
            'wpcui_section_control',
            [
                'name' => 'wpcui_controls',
                'label' => 'control_type',
                'options' => [
                    'Text',
                    'Text Block',
                    'Color Picker',
                    'Image'
                ]
            ]);
	}

	public function sanitizeControl( $input ) {
		$input['section'] = $_POST['section'];
		$output           = get_option( 'wpcui_controls' );

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

	public function deleteSection($section_name) {
        $sections = get_option( 'wpcui_sections' );
        $controls = get_option('wpcui_controls');

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

	public function sectionOutput() {
		echo '<p>Use this form to create a new Customizer section</p>';
	}

	public function controlOutput() {
		echo '<p>Create a new control</p>';
	}

	public function textField( $args ) {
		$name        = $args['label_for'];
		$option_name = $args['option_name'];
		$value       = '';

		echo '<input type="text" class="regular-text" id="' . $name . '" name="' . $option_name . '[' . $name . ']" value="' . $value . '" placeholder="' . $args['placeholder'] . '" required>';
	}

	public function dropDown( $args ) {
	    $name = $args['name'];
	    $label = $args['label'];

	    $eleName = $name . "[$label]";
	    echo "<select name=\"$eleName\">";

	    foreach($args['options'] as $option) {
	        $option_id = str_replace(' ', '_', $option);
	        echo "<option value=$option_id>$option</option>";
        }

	    echo '</select>';
    }
}