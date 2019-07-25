<?php

namespace Inc\Base;

class Activate extends BaseController {
	public static function activate() {
		flush_rewrite_rules();

		self::setDefaultOptionsArrays(['wpcui_sections', 'wpcui_controls']);
	}

	private static function setDefaultOptionsArrays($options) {
		foreach($options as $option) {
			if ( ! get_option( $option ) ) {
				update_option( $option, [] );
			}
		}
	}
}