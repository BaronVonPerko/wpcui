<?php

namespace Inc\Services;

class DataService
{
    public static function getSections()
    {
        return get_option('wpcui_sections');
    }

    public static function getControls() {
        return get_option('wpcui_controls');
    }

    public static function setDefaults() {
        $options = ['wpcui_sections', 'wpcui_controls'];
        foreach($options as $option) {
            if ( ! get_option( $option ) ) {
                update_option( $option, [] );
            }
        }
    }
}