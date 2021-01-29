<?php

namespace PerkoCustomizerUI\API;

class CustomizerLookupController extends BaseAPI {

	function addRestEndpoints() {
		$this->getCustomizerSections();
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
}