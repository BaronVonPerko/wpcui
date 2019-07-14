<?php

namespace Inc\Base;

class SettingsLinks extends BaseController
{
    public function register()
    {
        add_filter("plugin_action_links_$this->plugin_name", [$this, 'settings_links']);
    }

    function settings_links($links)
    {
        $settings_link = '<a href="admin.php?page=wpcui">Settings</a>';
        array_push($links, $settings_link);
        return $links;
    }
}