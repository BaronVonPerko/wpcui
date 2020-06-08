<?php

namespace PerkoCustomizerUI\Services;

use PerkoCustomizerUI\Data\DataService;

/**
 * Class AdminSettingsService
 * @package PerkoCustomizerUI\Services
 *
 * This service is used to register all of the settings,
 * sections, and fields used by forms within the Admin page.
 */
class AdminSettingsService {

	private $formControlService;
	private $sanitizer;


	public function __construct() {
		$this->formControlService = new FormControlsService();
		$this->sanitizer          = new AdminSanitizerService();
	}


	public function setSettings() {

		/**
		 * Register Plugin Settings
		 */
		register_setting(
			'wpcui',
			'wpcui_settings',
			[ $this->sanitizer, 'sanitizeSettings' ]
		);

		$this->addSectionSettings();
		$this->addControlSettings();
	}

	/**
	 * Add the settings for the customizer sections.
	 */
	private function addSectionSettings() {
		add_settings_section(
			'wpcui_section_index',
			'Add Section',
			[ $this, 'sectionOutput' ],
			'wpcui'
		);

		add_settings_field( 'section_title',
			'Section Title',
			[ $this->formControlService, 'textField' ],
			'wpcui',
			'wpcui_section_index',
			[
				'option_name' => 'wpcui_settings',
				'label_for'   => 'section_title',
				'placeholder' => 'eg. Personal Info',
				'value'       => ''
			] );
	}

	/**
	 * Add the settings for the customizer controls
	 */
	private function addControlSettings() {
		$title           = 'Add Control';
		$existingControl = null;
		if ( AdminFormStatusService::IsEditControl() ) {
			$title           = 'Edit Control';
			$existingControl = DataService::getControlById( sanitize_text_field( $_POST[ AdminFormStatus::EditControl ] ) );
		}

		add_settings_section(
			'wpcui_section_control',
			$title,
			[ $this, 'controlOutput' ],
			'wpcui-control'
		);

		add_settings_field( 'control_id',
			'Control ID',
			[ $this->formControlService, 'textField' ],
			'wpcui-control',
			'wpcui_section_control',
			[
				'option_name' => 'wpcui_settings',
				'label_for'   => 'control_id',
				'placeholder' => 'eg. location_info',
				'required'    => 'required',
				'value'       => $existingControl ? $existingControl->id : ''
			] );

		add_settings_field( 'control_label',
			'Control Label',
			[ $this->formControlService, 'textField' ],
			'wpcui-control',
			'wpcui_section_control',
			[
				'option_name' => 'wpcui_settings',
				'label_for'   => 'control_label',
				'placeholder' => 'eg. Location Info',
				'required'    => 'required',
				'value'       => $existingControl ? $existingControl->label : ''
			] );

		add_settings_field( 'control_type',
			'Control Type',
			[ $this->formControlService, 'groupedDropDown' ],
			'wpcui-control',
			'wpcui_section_control',
			[
				'option_name' => 'wpcui_settings',
				'label_for'   => 'control_type',
				'html_id'     => 'dropdown_control_type',
				'html_class'  => 'dropdown_control_type',
				'options'     => self::getControlTypeOptions(),
				'value'       => $existingControl ? $existingControl->type : ''
			] );

		add_settings_field( 'control_choices',
			'Control Choices',
			[ $this->formControlService, 'textArea' ],
			'wpcui-control',
			'wpcui_section_control',
			[
				'option_name' => 'wpcui_settings',
				'label_for'   => 'control_choices',
				'placeholder' => 'Comma separated values.  Ex. Soup,Pastas,Buffets',
				'class'       => 'hidden control-choices',
				'value'       => $existingControl ? $existingControl->choices : ''
			] );

		add_settings_field( 'control_default',
			'Default Value',
			[ $this->formControlService, 'textField' ],
			'wpcui-control',
			'wpcui_section_control',
			[
				'option_name' => 'wpcui_settings',
				'label_for'   => 'control_default',
				'placeholder' => 'Default value',
				'value'       => $existingControl ? $existingControl->default : ''
			] );
	}

	public function sectionOutput() {
		echo '<p>Use this form to create a new Customizer section</p>';
	}

	public function controlOutput() {
		if ( array_key_exists( 'edit_control_id', $_POST ) ) {
			echo '<p>Edit control</p>';
		} else {
			echo '<p>Create a new control</p>';
		}
	}

	private static function getControlTypeOptions() {
		return [
			'Standard'      => [
				[ 'name' => 'Text' ],
				[ 'name' => 'Text Area' ],
				[ 'name' => 'Select', 'has_options' => true ],
				[ 'name' => 'Radio', 'has_options' => true ],
				[ 'name' => 'Dropdown Pages' ],
				[ 'name' => 'Email' ],
				[ 'name' => 'URL' ],
				[ 'name' => 'Number' ],
				[ 'name' => 'Date' ],
			],
			'Media / Color' => [
				[ 'name' => 'Upload' ],
				[ 'name' => 'Image' ],
				[ 'name' => 'Color Picker' ],
			]
		];
	}

}