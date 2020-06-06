<?php

namespace PerkoCustomizerUI\Services;

/**
 * Class SectionManagerSettingsService
 * @package PerkoCustomizerUI\Services
 *
 */
class SectionManagerSettingsService {

	private $formControlService;
	private $sanitizer;


	public function __construct() {
		$this->formControlService = new FormControlsService();
		$this->sanitizer          = new SectionManagerSanitizerService();
	}


	public function setSettings() {
		register_setting(
			'wpcui',
			'wpcui_settings',
			[ $this->sanitizer, 'sanitizeSectionManager' ]
		);
	}

}