<?php

namespace PerkoCustomizerUI\Services;

/**
 * Class FormControlsService
 * @package PerkoCustomizerUI\Services
 *
 * This service can be used to dynamically create form controls
 * to be used within the backend pages and forms.
 */
class FormControlsService {
	public function textField( $args ) {
		$required = '';
		if ( array_key_exists( 'required', $args ) ) {
			$required = $args['required'];
		}

		$name        = $args['label_for'];
		$option_name = $args['option_name'];
		$value       = $args['value'];

		echo '<input type="text" class="regular-text" id="' . $name . '" name="' . $option_name . '[' . $name . ']" value="' . $value . '" placeholder="' . $args['placeholder'] . '" ' . $required . '>';
	}

	public function textArea( $args ) {
		$required = '';
		if ( array_key_exists( 'required', $args ) ) {
			$required = $args['required'];
		}

		$name        = $args['label_for'];
		$option_name = $args['option_name'];
		$value       = $args['value'];
		$required    = $required;

		echo '<textarea rows="4" class="regular-text" id="' . $name . '" name="' . $option_name . '[' . $name . ']" value="' . $value . '" placeholder="' . $args['placeholder'] . ' ' . $required . '">' . $value . '</textarea>';
	}

	public function groupedDropDown( $args ) {
		$name      = $args['option_name'];
		$label     = $args['label_for'];
		$groups    = $args['options'];
		$eleName   = $name . "[$label]";
		$className = ' class="' . $args['html_class'] . '"';
		$htmlId    = $args['html_id'] ? ' id="' . $args['html_id'] . '"' : '';
		$value     = $args['value'];

		echo "<select $htmlId $className name=\"$eleName\">";

		foreach ( $groups as $group => $options ) {
			echo "<optgroup label=\"$group\">";

			foreach ( $options as $option ) {
				$option_name = $option['name'];
				$option_id   = str_replace( ' ', '_', $option_name );
				$has_options = array_key_exists('has_options', $option) && $option['has_options'] == 'true';
				$selected = $option_id == $value ? 'selected' : '';

				echo "<option data-has-options='$has_options' value='$option_id' $selected>$option_name</option>";
			}

			echo "</optgroup>";
		}

		echo "</select>";
	}

}