<?php

namespace Inc\Pages;

use Inc\Base\BaseController;

class Admin extends BaseController {

    public function register() {
        add_action('admin_menu', [$this, 'add_admin_page']);
    }

    function admin_index()
    {
        require_once "$this->plugin_path/templates/admin.php";
    }

    function add_admin_page()
    {
        add_menu_page('WPCUI Plugin', 'WPCUI', 'manage_options', 'wpcui', [$this, 'admin_index'],
            'dashicons-admin-customizer', 110);
    }


}