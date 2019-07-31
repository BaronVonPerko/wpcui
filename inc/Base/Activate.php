<?php

namespace Inc\Base;

use Inc\Services\DataService;

class Activate extends BaseController {
	public static function activate() {
		flush_rewrite_rules();

		DataService::setDefaults();
	}
}