<?php


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


function wpcui_admin_init() {
    return require_once(plugin_dir_path(__FILE__) . '/options.php');
}

function wpcui_register_menu_page(){
    add_menu_page( 'WPCUI', 'WPCUI', 'manage_options', 'wpcui', 'wpcui_admin_init' );
}
add_action('admin_menu', 'wpcui_register_menu_page');