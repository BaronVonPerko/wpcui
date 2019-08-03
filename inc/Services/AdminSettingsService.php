<?php

namespace Inc\Services;


class AdminSettingsService
{

    private $formControlService;
    private $sanitizer;


    public function __construct()
    {
        $this->formControlService = new FormControlsService();
        $this->sanitizer          = new AdminSanitizerService();
    }


    public function setSettings()
    {

        /**
         * Section Settings
         */
        register_setting('wpcui', 'wpcui_sections', [$this->sanitizer, 'sanitizeSection']);

        add_settings_section('wpcui_section_index', 'Add Section', [$this, 'sectionOutput'], 'wpcui');

        add_settings_field('section_title',
            'Section Title',
            [$this->formControlService, 'textField'],
            'wpcui',
            'wpcui_section_index',
            [
                'option_name' => 'wpcui_sections',
                'label_for' => 'section_title',
                'placeholder' => 'eg. Personal Info',
            ]);


        /**
         * Control Settings
         */
        register_setting('wpcui-control', 'wpcui_controls', [$this->sanitizer, 'sanitizeControl']);

        add_settings_section('wpcui_section_control', 'Add Control', [$this, 'controlOutput'], 'wpcui-control');

        add_settings_field('control_id',
            'Control ID',
            [$this->formControlService, 'textField'],
            'wpcui-control',
            'wpcui_section_control',
            [
                'option_name' => 'wpcui_controls',
                'label_for' => 'control_id',
                'placeholder' => 'eg. location_info'
            ]);

        add_settings_field('control_label',
            'Control Label',
            [$this->formControlService, 'textField'],
            'wpcui-control',
            'wpcui_section_control',
            [
                'option_name' => 'wpcui_controls',
                'label_for' => 'control_label',
                'placeholder' => 'eg. Location Info'
            ]);

        add_settings_field('control_type',
            'Control Type',
            [$this->formControlService, 'groupedDropDown'],
            'wpcui-control',
            'wpcui_section_control',
            [
                'option_name' => 'wpcui_controls',
                'label_for' => 'control_type',
                'html_id' => 'dropdown_control_type',
                'options' => [
                    'Standard' => [
                        ['name' => 'Text'],
                        ['name' => 'Text Area'],
                        ['name' => 'Select', 'has_options' => true],
                        ['name' => 'Radio', 'has_options' => true],
                        ['name' => 'Dropdown Pages'],
                        ['name' => 'Email'],
                        ['name' => 'URL'],
                        ['name' => 'Number'],
                        ['name' => 'Date'],
                    ],
                    'Media / Color' => [
                        ['name' => 'Upload'],
                        ['name' => 'Image'],
	                    ['name' => 'Color Picker'],
                    ]
                ]
            ]);

        add_settings_field('control_choices',
            'Control Choices',
            [$this->formControlService, 'textArea'],
            'wpcui-control',
            'wpcui_section_control',
            [
                'option_name' => 'wpcui_controls',
                'label_for' => 'control_choices',
                'placeholder' => 'Comma separated values',
                'class' => 'hidden control-choices',
            ]);
    }

    public function sectionOutput()
    {
        echo '<p>Use this form to create a new Customizer section</p>';
    }

    public function controlOutput()
    {
        echo '<p>Create a new control</p>';
    }

}