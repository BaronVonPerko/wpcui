<?php

namespace PerkoCustomizerUI\Base;

/**
 * Class SettingsLinks
 * @package PerkoCustomizerUI\Base
 */
class SettingsLinks extends BaseController
{
    public function register()
    {
        $file = plugin_basename(__FILE__);
        add_filter("plugin_action_links_wpcui/wpcui.php", [$this, 'setup']);
//        add_filter("plugin_action_links", [$this, 'setup']);
    }

    function setup($plugin_actions)
    {
        $settings_link = '<a href="admin.php?page=wpcui">Settings</a>';
        array_push($plugin_actions, $settings_link);
        return $plugin_actions;
    }
}