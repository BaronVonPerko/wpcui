<?php

namespace PerkoCustomizerUI\Services;


use PerkoCustomizerUI\Data\DataService;
use WP_Customize_Color_Control;
use WP_Customize_Control;
use WP_Customize_Image_Control;
use WP_Customize_Upload_Control;

/**
 * Class CustomizerGenerator
 * @package PerkoCustomizerUI\Services
 *
 * This service is used to do the actual registration of settings,
 * sections, and fields for use within the WordPress customizer.
 */
class CustomizerGenerator {

	/**
	 * Generate all of the settings, sections, and controls for
	 * the WP Customizer.
	 *
	 * @param $wp_customize
	 * @param $sections
	 */
	public static function Generate( $wp_customize, $sections ) {
		$validator      = new CustomizerValidationService();
		$control_prefix = DataService::getControlIdPrefix();

		$sections = array_filter( $sections, function ( $section ) {
			return $section->visible;
		} );

		foreach ( $sections as $section ) {

			self::registerSection( $wp_customize, $section );

			foreach ( $section->controls as $control ) {
				self::registerControl( $wp_customize, $control, $section, $validator, $control_prefix );
			}
		}
	}


	/**
	 * Update the core sections
	 *
	 * @param $wp_customize
	 * @param $sections
	 */
	public static function UpdateCoreSections( $wp_customize, $sections ) {
		foreach ( $sections as $section ) {
			$wp_customize->get_section( $section->id )->priority = $section->priority;

			if ( ! $section->visible ) {
				$wp_customize->remove_section( $section->id );
			}
		}
	}

	/**
	 * Register the customizer setting
	 *
	 * @param $wp_customize
	 * @param $setting
	 * @param $validator
	 * $id_prefix
	 */
	private static function registerSetting( $wp_customize, $setting, $validator ) {
		$args = [
			'default'   => $setting->default,
			'transport' => 'refresh',
		];

		$validation = $validator->getValidation( $setting );
		if ( ! empty( $validation ) ) {
			$args['validate_callback'] = $validation;
		}

		$wp_customize->add_setting( $setting->id, $args );
	}


	/**
	 * Register a customizer section.
	 *
	 * @param $wp_customize
	 * @param $section
	 */
	private static function registerSection( $wp_customize, $section ) {
		$wp_customize->add_section( $section->id, array(
			'title'    => __( $section->title ),
			'priority' => $section->priority,
		) );
	}


	/**
	 * Register a customizer control.
	 *
	 * @param $wp_customize
	 * @param $control
	 * @param $section
	 * @param $validator
	 * @param $control_id_prefix
	 */
	private static function registerControl( $wp_customize, $control, $section, $validator, $control_id_prefix ) {

		if ( ! empty( $control_id_prefix ) ) {
			$control->id         = $control_id_prefix . '_' . $control->id;
		}

		self::registerSetting( $wp_customize, $control, $validator );

		switch ( $control->type ) {
			case "Text":
				self::registerStandardControl( $wp_customize, $control, $section, 'text' );
				break;
			case "Text_Area":
				self::registerStandardControl( $wp_customize, $control, $section, 'textarea' );
				break;
			case "Dropdown_Pages":
				self::registerStandardControl( $wp_customize, $control, $section, 'dropdown-pages' );
				break;
			case 'Email':
				self::registerStandardControl( $wp_customize, $control, $section, 'email' );
				break;
			case 'URL':
				self::registerStandardControl( $wp_customize, $control, $section, 'url' );
				break;
			case 'Number':
				self::registerStandardControl( $wp_customize, $control, $section, 'number' );
				break;
			case 'Date':
				self::registerStandardControl( $wp_customize, $control, $section, 'date' );
				break;
			case "Select":
				self::registerChoicesControl( $wp_customize, $control, $section, 'select' );
				break;
			case "Radio":
				self::registerChoicesControl( $wp_customize, $control, $section, 'radio' );
				break;
			case "Color_Picker":
				self::registerColorControl( $wp_customize, $control, $section );
				break;
			case "Upload":
				self::registerUploadControl( $wp_customize, $control, $section );
				break;
			case "Image":
				self::registerImageControl( $wp_customize, $control, $section );
				break;
		}
	}

	private static function registerStandardControl( $wp_customize, $control, $section, $type ) {
		$wp_customize->add_control( new WP_Customize_Control(
			$wp_customize,
			$control->id,
			[
				'label'    => __( $control->label ),
				'section'  => $section->id,
				'settings' => $control->id,
				'type'     => $type,
			]
		) );
	}

	private static function registerChoicesControl( $wp_customize, $control, $section, $type ) {
		$choices = [];
		foreach ( explode( ',', $control->choices ) as $choice ) {
			$choices[ $choice ] = $choice;
		}

		$wp_customize->add_control( new WP_Customize_Control(
			$wp_customize,
			$control->id,
			[
				'label'    => __( $control->label ),
				'section'  => $section->id,
				'settings' => $control->id,
				'type'     => $type,
				'choices'  => $choices
			]
		) );
	}

	private static function registerColorControl( $wp_customize, $control, $section ) {
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize,
			$control->id,
			[
				'label'    => __( $control->label ),
				'section'  => $section->id,
				'settings' => $control->id,
			]
		) );
	}

	private static function registerUploadControl( $wp_customize, $control, $section ) {
		$wp_customize->add_control( new WP_Customize_Upload_Control(
			$wp_customize,
			$control->id,
			[
				'label'    => __( $control->label ),
				'section'  => $section->id,
				'settings' => $control->id,
			]
		) );
	}

	private static function registerImageControl( $wp_customize, $control, $section ) {
		$wp_customize->add_control( new WP_Customize_Image_Control(
			$wp_customize,
			$control->id,
			[
				'label'    => __( $control->label ),
				'section'  => $section->id,
				'settings' => $control->id,
			]
		) );
	}
}