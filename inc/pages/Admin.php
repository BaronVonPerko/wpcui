<?php

namespace Inc\Pages;

use Inc\Base\BaseController;
use Inc\Classes\CustomizerControl;
use Inc\Classes\CustomizerSection;
use Inc\Classes\CustomizerSetting;
use Inc\Services\AdminSanitizerService;
use Inc\Services\AdminSettingsService;
use Inc\Services\CustomizerGenerator;
use Inc\Services\DataService;

class Admin extends BaseController {

	public $customizer_fields = [];
	public $customizer_sections = [];

	public function register() {
        $this->getSavedData();

        if ( ! empty( $this->customizer_fields ) && ! empty( $this->customizer_sections ) ) {
			add_action( 'customize_register', [ $this, 'registerCustomizerFields' ] );
		}

		add_action( 'admin_menu', [ $this, 'addAdminPage' ] );

		$settings_service = new AdminSettingsService();
		add_action( 'admin_init', [ $settings_service, 'setSettings' ] );
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

	public function getSavedData()
    {
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