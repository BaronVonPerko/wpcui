<?php

namespace PerkoCustomizerUI\Services;

/**
 * Class SettingsPageSettingsService
 * @package PerkoCustomizerUI\Services
 *
 * This service is used to register all of the settings,
 * sections, and fields used by forms within the Settings page.
 */
class SettingsPageSettingsService {

	private $formControlService;
	private $sanitizer;


	public function __construct() {
		$this->formControlService = new FormControlsService();
		$this->sanitizer          = new SettingsSanitizerService();
	}


	public function setSettings() {

		/**
		 * Register Plugin Settings
		 */
		register_setting(
			'wpcui',
			'wpcui_settings',
			[ $this->sanitizer, 'sanitizeControlPrefix' ]
		);

		$this->addSettings();
	}

	/**
	 * Add the settings.
	 */
	private function addSettings() {
		$settings = DataService::getSettings();

		add_settings_section(
			'wpcui_control_prefix_settings',
			'Control Auto Prefix',
			[ $this, 'controlPrefixOutput' ],
			'wpcui-settings'
		);

		add_settings_field( 'control_prefix',
			'Control Prefix',
			[ $this->formControlService, 'textField' ],
			'wpcui-settings',
			'wpcui_control_prefix_settings',
			[
				'option_name' => 'wpcui_control_prefix',
				'label_for'   => 'control_prefix',
				'placeholder' => 'eg. mytheme',
				'value'       => array_key_exists( 'control_prefix', $settings ) ? $settings['control_prefix'] : ''
			] );
	}

	public function controlPrefixOutput() {
		?>
        <p>Use this form to set an automated prefix to all control IDs.</p>
        <p>
            <strong>Please Note: </strong>
            This will change the ID used by your code as well as the customizer. Any data that is currently
            saved in the customizer will be missing when you change the prefix, as it is still saved to the
            old id.
        </p>
		<?php
	}

}