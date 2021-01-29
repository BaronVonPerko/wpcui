<?php

namespace PerkoCustomizerUI;

use PerkoCustomizerUI\Data\DatabaseUpgrades;

/**
 * Class Init
 * @package PerkoCustomizerUI
 */
final class Init
{

    public static function get_services()
    {
        return [
            Pages\Admin::class,
            Base\SettingsLinks::class,
            Base\Enqueue::class,
	        Forms\AdminPageForms::class,
	        DatabaseUpgrades::class,
	        API\CustomizerLookupController::class
        ];
    }

    public static function registerServices()
    {
        foreach (self::get_services() as $service_class) {
            $service = new $service_class();

            if (method_exists($service, 'register')) {
                $service->register();
            }
        }
    }

}