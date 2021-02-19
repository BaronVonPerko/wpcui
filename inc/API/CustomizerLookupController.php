<?php

namespace PerkoCustomizerUI\API;

use PerkoCustomizerUI\Data\DataService;

class CustomizerLookupController extends BaseAPI {

	function addRestEndpoints() {
		$this->getCustomizerSections();
		$this->getOptions();
		$this->saveOptions();
	}

	/** Routes */
	function getCustomizerSections() {
		register_rest_route( $this->base_path, "/getCustomizerSections", [
			[
				'methods'  => 'GET',
				'callback' => function () {

				}
			]
		] );
	}

	function getOptions() {
		register_rest_route( $this->base_path, "/getOptions", [
			[
				"methods"  => \WP_REST_Server::READABLE,
				"callback" => function () {
					return DataService::getSettings();
				}
			]
		] );
	}

	function saveOptions() {
		register_rest_route( $this->base_path, "/saveOptions", [
			[
				"methods"  => \WP_REST_Server::EDITABLE,
				"callback" => function ($data) {
					return $data;
				}
			]
		] );
	}
}