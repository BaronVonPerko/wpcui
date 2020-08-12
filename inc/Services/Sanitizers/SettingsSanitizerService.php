<?php

namespace PerkoCustomizerUI\Services\Sanitizers;

/**
 * Class SettingsSanitizerService
 * @package PerkoCustomizerUI\Services
 *
 * Service for sanitizing form requests from the Settings page
 */
class SettingsSanitizerService {

	/**
	 * Sanitization handler for saving the control id prefix form.
	 *
	 * @param $input
	 *
	 * @return array
	 */
	public function sanitizeControlPrefix( $input ): array {
		if ( array_key_exists( 'wpcui_control_prefix', $_POST ) ) {
			$input['control_prefix'] = sanitize_text_field( $_POST['wpcui_control_prefix']['control_prefix'] );
		}

		return $input;
	}

}