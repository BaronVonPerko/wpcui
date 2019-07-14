<?php

/*
Plugin Name: WPCUI
Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
Description: A brief description of the Plugin.
Version: 1.0
Author: chris
Author URI: http://URI_Of_The_Plugin_Author
License: A "Slug" license name e.g. GPL2
*/


defined('ABSPATH') or die("You have no power here!");

if (file_exists(dirname(__FILE__) . '/vendor/autoload.php')) {
    require_once dirname(__FILE__) . '/vendor/autoload.php';
}

if (class_exists('Inc\\Init')) {
    Inc\Init::register_services();
}

/**
 * The code that runs during plugin activation
 */
function activate_wpcui_plugin() {
    Inc\Base\Activate::activate();
}
register_activation_hook( __FILE__, 'activate_wpcui_plugin' );


/**
 * The code that runs during plugin deactivation
 */
function deactivate_wpcui_plugin() {
    \Inc\Base\Deactivate::deactivate();
}
register_deactivation_hook( __FILE__, 'deactivate_wpcui_plugin' );