<?php

namespace PerkoCustomizerUI\API;

use PerkoCustomizerUI\Base\BaseController;

class BaseAPI extends BaseController {
	public $base_path;

	public function __construct() {
		parent::__construct();

		$this->base_path = 'wpcui/v2';
		add_action( 'rest_api_init', [ $this, 'addRestEndpoints' ] );
	}
}