<?php

/*
Plugin Name: WPCUI
Plugin URI: https://ChrisPerko.net/WPCUI
Description: A brief description of the Plugin.
Version: 1.0
Author: Chris Perko
Author URI: https://ChrisPerko.net
License: GPL2
*/


defined('ABSPATH') or die("You have no power here!");

if (file_exists(dirname(__FILE__) . '/vendor/autoload.php')) {
    require_once dirname(__FILE__) . '/vendor/autoload.php';
}

/**
 * The code that runs during plugin activation
 */
function activateWpcuiPlugin() {
    Inc\Base\Activate::activate();
}
register_activation_hook( __FILE__, 'activateWpcuiPlugin' );


/**
 * The code that runs during plugin deactivation
 */
function deactivateWpcuiPlugin() {
    Inc\Base\Deactivate::deactivate();
}
register_deactivation_hook( __FILE__, 'deactivateWpcuiPlugin' );



if (class_exists('Inc\\Init')) {
    Inc\Init::registerServices();
}