<?php

namespace PerkoCustomizerUI\Pages;

use PerkoCustomizerUI\Base\BaseController;
use PerkoCustomizerUI\Services\AdminSettingsService;
use PerkoCustomizerUI\Services\DataService;

/**
 * Class Admin
 * @package PerkoCustomizerUI\Pages
 *
 * Create the plugin admin pages in the WordPress backend
 */
class Settings extends BaseController {

	public function register() {
		add_action( 'admin_menu', [ $this, 'addSettingsPage' ] );

		$settings_service = new AdminSettingsService();
		add_action( 'admin_init', [ $settings_service, 'setSettings' ] );
	}

	function settingsIndex() {
		require_once "$this->plugin_path/templates/settings.php";
	}

	function addSettingsPage() {
		add_submenu_page(
			'wpcui',
			'Settings',
			'Settings',
			'manage_options',
			'wpcui-settings',
			[ $this, 'settingsIndex' ]
		);
	}
}