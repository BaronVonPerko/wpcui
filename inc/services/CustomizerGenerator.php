<?php

namespace Inc\Services;


use WP_Customize_Color_Control;
use WP_Customize_Control;
use WP_Customize_Image_Control;
use WP_Customize_Upload_Control;

class CustomizerGenerator
{
    public static function Generate($wp_customize, $settings, $sections)
    {
        foreach ($settings as $setting) {
            self::registerSetting($wp_customize, $setting);
        }

        foreach ($sections as $section) {
            self::registerSection($wp_customize, $section);

            foreach ($section->controls as $control) {
                self::registerControl($wp_customize, $control, $section);
            }
        }
    }

    private function registerSetting($wp_customize, $setting)
    {
        $wp_customize->add_setting($setting->id, array(
            'default' => $setting->default,
            'transport' => 'refresh',
        ));
    }

    private function registerSection($wp_customize, $section)
    {
        $wp_customize->add_section($section->id, array(
            'title' => __($section->title),
            'priority' => $section->priority,
        ));
    }

    private function registerControl($wp_customize, $control, $section)
    {
        switch ($control->type) {
            case "Text":
                self::registerStandardControl($wp_customize, $control, $section, 'text');
                break;
            case "Text_Area":
                self::registerStandardControl($wp_customize, $control, $section, 'textarea');
                break;
            case "Dropdown_Pages":
                self::registerStandardControl($wp_customize, $control, $section, 'dropdown-pages');
                break;
            case 'Email':
                self::registerStandardControl($wp_customize, $control, $section, 'email');
                break;
            case 'URL':
                self::registerStandardControl($wp_customize, $control, $section, 'url');
                break;
            case 'Number':
                self::registerStandardControl($wp_customize, $control, $section, 'number');
                break;
            case 'Date':
                self::registerStandardControl($wp_customize, $control, $section, 'date');
                break;
            case "Select":
                self::registerChoicesControl($wp_customize, $control, $section, 'select');
                break;
            case "Radio":
                self::registerChoicesControl($wp_customize, $control, $section, 'radio');
                break;
	        case "Color_Picker":
	        	self::registerColorControl($wp_customize, $control, $section);
	        	break;
	        case "Upload":
		        self::registerUploadControl($wp_customize, $control, $section);
		        break;
	        case "Image":
		        self::registerImageControl($wp_customize, $control, $section);
		        break;
        }
    }

    private function registerStandardControl($wp_customize, $control, $section, $type)
    {
        $wp_customize->add_control(new WP_Customize_Control(
        	$wp_customize,
	        $control->id,
	        [
	            'label' => __($control->label),
	            'section' => $section->id,
	            'settings' => $control->settings,
	            'type' => $type,
	        ]
        ));
    }

    private function registerChoicesControl($wp_customize, $control, $section, $type)
    {
        $wp_customize->add_control(new WP_Customize_Control(
        	$wp_customize,
	        $control->id,
	        [
	            'label' => __($control->label),
	            'section' => $section->id,
	            'settings' => $control->settings,
	            'type' => $type,
	            'choices' => $control->choices
	        ]
        ));
    }

    private function registerColorControl($wp_customize, $control, $section) {
    	$wp_customize->add_control(new WP_Customize_Color_Control(
            $wp_customize,
		    $control->id,
		    [
			    'label' => __($control->label),
			    'section' => $section->id,
			    'settings' => $control->settings,
		    ]
	    ));
    }

	private function registerUploadControl($wp_customize, $control, $section) {
		$wp_customize->add_control(new WP_Customize_Upload_Control(
			$wp_customize,
			$control->id,
			[
				'label' => __($control->label),
				'section' => $section->id,
				'settings' => $control->settings,
			]
		));
	}

	private function registerImageControl($wp_customize, $control, $section) {
		$wp_customize->add_control(new WP_Customize_Image_Control(
			$wp_customize,
			$control->id,
			[
				'label' => __($control->label),
				'section' => $section->id,
				'settings' => $control->settings,
			]
		));
	}
}