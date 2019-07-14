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
}