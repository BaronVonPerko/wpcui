<?php

namespace PerkoCustomizerUI\Pages;

use PerkoCustomizerUI\Base\BaseController;
use PerkoCustomizerUI\Services\AdminSettingsService;
use PerkoCustomizerUI\Services\DataService;
use PerkoCustomizerUI\Services\SettingsPageSettingsService;

/**
 * Class SectionManager
 * @package PerkoCustomizerUI\Pages
 *
 * Create the Section Manager page in the WordPress backend
 */
class SectionManager extends BaseController {

	public function register() {
		add_action( 'admin_menu', [ $this, 'addSectionManagerPage' ] );

		$settings_service = new SettingsPageSettingsService();
		add_action( 'admin_init', [ $settings_service, 'setSettings' ] );
	}

	function sectionManagerIndex() {
		require_once "$this->plugin_path/templates/section-manager.php";
	}

	function addSectionManagerPage() {
		add_submenu_page(
			'wpcui',
			'Section Manager',
			'Section Manager',
			'manage_options',
			'wpcui-section-manager',
			[ $this, 'sectionManagerIndex' ]
		);
	}
}