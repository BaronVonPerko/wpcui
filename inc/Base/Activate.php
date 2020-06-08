<?php

namespace PerkoCustomizerUI\Base;

use PerkoCustomizerUI\Data\DataService;

/**
 * Class Activate
 * @package PerkoCustomizerUI\Base
 */
class Activate extends BaseController {
	public static function activate() {
		flush_rewrite_rules();

		DataService::setDefaults();
	}
}