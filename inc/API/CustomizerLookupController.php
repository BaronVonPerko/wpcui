<?php

namespace PerkoCustomizerUI\API;

use PerkoCustomizerUI\Data\DataService;
use WP_REST_Server;

class CustomizerLookupController extends BaseAPI {

	function addRestEndpoints() {
		$this->getOptions();
		$this->saveOptions();
	}

	/** Routes */

	function getOptions() {
		register_rest_route( $this->base_path, "/getOptions", [
			[
				"methods"  => WP_REST_Server::READABLE,
				"callback" => function () {
					return DataService::getSettings();
				}
			]
		] );
	}

	function saveOptions() {
		register_rest_route( $this->base_path, "/saveOptions", [
			[
				"methods"  => WP_REST_Server::EDITABLE,
				"callback" => function ( $data ) {
					DataService::setSettings( $data->get_json_params()['data'] );
				}
			]
		] );
	}
}