<?php

namespace Inc\Services;


class AdminSettingsService
{

    private $form_control_service;
    private $sanitizer;

    public function __construct()
    {
        $this->form_control_service = new FormControlsService();
        $this->sanitizer = new AdminSanitizerService();
    }

    public function setSettings()
    {

        /** Section Settings */
        register_setting('wpcui', 'wpcui_sections', [$this->sanitizer, 'sanitize']);

        add_settings_section('wpcui_section_index', 'Add Section', [$this, 'sectionOutput'], 'wpcui');

        add_settings_field('section_title',
            'Section Title',
            [$this->form_control_service, 'textField'],
            'wpcui',
            'wpcui_section_index',
            [
                'option_name' => 'wpcui_sections',
                'label_for' => 'section_title',
                'placeholder' => 'eg. Personal Info',
            ]);


        /** Control Settings */
        register_setting('wpcui-control', 'wpcui_controls', [$this->sanitizer, 'sanitizeControl']);

        add_settings_section('wpcui_section_control', 'Add Control', [$this, 'controlOutput'], 'wpcui-control');

        add_settings_field('control_id',
            'Control ID',
            [$this->form_control_service, 'textField'],
            'wpcui-control',
            'wpcui_section_control',
            [
                'option_name' => 'wpcui_controls',
                'label_for' => 'control_id',
                'placeholder' => 'eg. location_info'
            ]);

        add_settings_field('control_label',
            'Control Label',
            [$this->form_control_service, 'textField'],
            'wpcui-control',
            'wpcui_section_control',
            [
                'option_name' => 'wpcui_controls',
                'label_for' => 'control_label',
                'placeholder' => 'eg. Location Info'
            ]);

        add_settings_field('control_type',
            'Control Type',
            [$this->form_control_service, 'groupedDropDown'],
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
                        ['name' => 'Select', 'has_options' => true]
                    ],
                    'Media' => [
                        ['name' => 'Upload'],
                        ['name' => 'Media Library']
                    ]
                ]
            ]);

        add_settings_field('control_options',
            'Control Options',
            [$this->form_control_service, 'textArea'],
            'wpcui-control',
            'wpcui_section_control',
            [
                'option_name' => 'wpcui_controls',
                'label_for' => 'control_options',
                'placeholder' => 'Comma separated values',
                'class' => 'hidden control-options',
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