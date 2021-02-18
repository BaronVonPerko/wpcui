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
				"methods"  => "GET",
				"callback" => function () {
					return DataService::getSettings();
				}
			]
		] );
	}

	function saveOptions() {
		register_rest_route( $this->base_path, "/saveOptions", [
			[
				"methods"  => "PUT",
				"callback" => function ($data) {
					return $data;
				}
			]
		] );
	}
}