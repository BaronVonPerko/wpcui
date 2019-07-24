<?php

namespace Inc\Base;

class Activate extends BaseController {
	public static function activate() {
		flush_rewrite_rules();

		if ( ! get_option( 'wpcui_sections' ) ) {
			update_option( 'wpcui_sections', [] );
		}
	}
}