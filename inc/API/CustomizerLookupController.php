<?php

namespace PerkoCustomizerUI\API;

use PerkoCustomizerUI\Base\BaseController;

class CustomizerLookupController extends BaseController {
	public $base_path;

	public function __construct() {
		parent::__construct();
		$this->base_path = 'wpcui/v2';
	}

	public function register() {
		add_action( 'rest_api_init', [$this, 'addRestEndpoints']);
	}

	function addRestEndpoints() {
		$this->test();
	}

	/** Routes */
	function test() {
		register_rest_route( $this->base_path, "/test", [
			[
				'methods' => 'GET',
				'callback' => [$this, 'getTestValues'],
			]
		]);
	}

	/** Callbacks */
	function getTestValues() {
		return [1,2,3,4,5];
	}
}