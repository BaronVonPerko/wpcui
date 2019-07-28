<?php

namespace Inc\Base;

class Enqueue extends BaseController {
    public function register() {
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
    }

    public function enqueue() {
        wp_enqueue_script( 'wpcui_script', $this->plugin_url . 'inc/assets/wpcui.js' );
    }
}