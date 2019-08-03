<?php

namespace Inc\Pages;

use Inc\Base\BaseController;
use Inc\Services\AdminSettingsService;
use Inc\Services\DataService;

class Admin extends BaseController {

	public function register() {
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
}