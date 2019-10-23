<?php

namespace PerkoCustomizerUI\Base;

class Enqueue extends BaseController {
    public function register() {
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
    }

    public function enqueue() {
        wp_enqueue_script( 'wpcui_script', $this->plugin_url . 'assets/wpcui.js' );
	    wp_enqueue_style('wpcui_style', $this->plugin_url . 'assets/wpcui.css');
    }
}