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
	}

	function adminIndex() {
		require_once "$this->plugin_path/templates/admin.php";
	}

	function addAdminPage() {
		add_management_page(
			'WPCUI Plugin',
			'Customizer UI',
			'manage_options',
			'wpcui',
			[ $this, 'adminIndex' ],
			110
		);
	}
}