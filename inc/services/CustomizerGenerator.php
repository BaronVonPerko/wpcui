<?php

namespace Inc\Services;


use WP_Customize_Control;

class CustomizerGenerator {
	public static function Generate($wp_customize, $settings, $sections) {
		foreach($settings as $setting) {
			self::registerSetting($wp_customize, $setting);
		}

		foreach($sections as $section) {
			self::registerSection($wp_customize, $section);

			foreach($section->controls as $control) {
				self::registerControl($wp_customize, $control, $section);
			}
		}
	}

	private function registerSetting($wp_customize, $setting) {
		$wp_customize->add_setting( $setting->id , array(
			'default'   => $setting->default,
			'transport' => 'refresh',
		) );
	}

	private function registerSection($wp_customize, $section) {
		$wp_customize->add_section( $section->id , array(
			'title'      => __( $section->title ),
			'priority'   => $section->priority,
		) );
	}

	private function registerControl($wp_customize, $control, $section) {
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, $control->id, array(
			'label'      => __( $control->label ),
			'section'    => $section->id,
			'settings'   => $control->settings,
		) ) );
	}
}