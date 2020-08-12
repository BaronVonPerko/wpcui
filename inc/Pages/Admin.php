<?php

namespace PerkoCustomizerUI\Pages;

use PerkoCustomizerUI\Base\BaseController;
use PerkoCustomizerUI\Services\Settings\AdminSettingsService;

/**
 * Class Admin
 * @package PerkoCustomizerUI\Pages
 *
 * Create the admin page in the WordPress backend
 */
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
		add_menu_page(
			'WPCUI Plugin',
			'Customizer UI',
			'manage_options',
			'wpcui',
			[ $this, 'adminIndex' ],
			'dashicons-admin-customizer', 110
		);
	}
}