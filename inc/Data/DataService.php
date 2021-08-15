<?php

namespace PerkoCustomizerUI\Data;

use PerkoCustomizerUI\Classes\CustomizerControl;
use PerkoCustomizerUI\Classes\CustomizerSection;

/**
 * Class DataService
 * @package PerkoCustomizerUI\Services
 *
 * The purpose of this service is to retrieve and update
 * data in the database.
 */
class DataService
{

    public static function getSettings()
    {
        return get_option('wpcui_settings');
    }

    public static function setSettings($settings)
    {
        update_option('wpcui_settings', $settings);
    }

}