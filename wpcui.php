<?php

/*
Plugin Name: Wpcui
Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
Description: A brief description of the Plugin.
Version: 1.0
Author: chris
Author URI: http://URI_Of_The_Plugin_Author
License: A "Slug" license name e.g. GPL2
*/



function wpcui_customize_register($wp_customize) {
    $contents = file_get_contents("encoded.json", true);
    $data = json_decode($contents);

    foreach($data->settings as $setting) {
        wpcui_register_setting($wp_customize, $setting);
    }

    foreach($data->sections as $section) {
        wpcui_register_section($wp_customize, $section);

        foreach($section->controls as $control) {
            wpcui_register_control($wp_customize, $control, $section);
        }
    }
}
add_action( 'customize_register', 'wpcui_customize_register' );


function wpcui_register_setting($wp_customize, $setting) {
    $wp_customize->add_setting( $setting->id , array(
        'default'   => $setting->default,
        'transport' => 'refresh',
    ) );
}

function wpcui_register_section($wp_customize, $section) {
    $wp_customize->add_section( $section->id , array(
        'title'      => __( $section->title ),
        'priority'   => $section->priority,
    ) );
}

function wpcui_register_control($wp_customize, $control, $section) {
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, $control->id, array(
        'label'      => __( $control->label ),
        'section'    => $section->id,
        'settings'   => $control->settings,
    ) ) );
}