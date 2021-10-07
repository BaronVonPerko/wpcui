<?php


namespace PerkoCustomizerUI\Services;


use PerkoCustomizerUI\Classes\CustomizerControl;

/**
 * Class CustomizerValidationService
 * @package PerkoCustomizerUI\Services
 */
class CustomizerValidationService {

	public function getValidation( CustomizerControl $setting ) {
		switch ( $setting->type ) {
			case 'Number':
				return [ $this, 'validate_number' ];
			case 'URL':
				return [ $this, 'validate_url' ];
			case 'Email':
				return [ $this, 'validate_email' ];
		}
	}

	public function validate_number( $validity, $value ) {
		if ( ! is_numeric( $value ) ) {
			$validity->add( 'not_numeric', 'The value must be a number' );
		}

		return $validity;
	}

	public function validate_url( $validity, $value ) {
		if ( ! filter_var( $value, FILTER_VALIDATE_URL ) ) {
			$validity->add( 'not_url', 'The value must be a valid URL, starting with http:// or https://' );
		}

		return $validity;
	}

	public function validate_email( $validity, $value ) {
		if ( ! filter_var( $value, FILTER_VALIDATE_EMAIL ) ) {
			$validity->add( 'not_url', 'The value must be a valid email address' );
		}

		return $validity;
	}
}