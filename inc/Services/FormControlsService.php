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
		$value       = '';

		echo '<input type="text" class="regular-text" id="' . $name . '" name="' . $option_name . '[' . $name . ']" value="' . $value . '" placeholder="' . $args['placeholder'] . '" ' . $required . '>';
	}

	public function textArea( $args ) {
		$required = '';
		if ( array_key_exists( 'required', $args ) ) {
			$required = $args['required'];
		}

		$name        = $args['label_for'];
		$option_name = $args['option_name'];
		$value       = '';
		$required    = $required;

		echo '<textarea rows="4" class="regular-text" id="' . $name . '" name="' . $option_name . '[' . $name . ']" value="' . $value . '" placeholder="' . $args['placeholder'] . ' ' . $required . '"></textarea>';
	}

	public function dropDown( $args ) {
		var_dump( $args );
		die;
		$name  = $args['option_name'];
		$label = $args['label_for'];

		$eleName = $name . "[$label]";
		echo "<select name=\"$eleName\">";

		foreach ( $args['options'] as $option ) {
			$option_id = str_replace( ' ', '_', $option );
			echo "<option value=$option_id>$option</option>";
		}

		echo '</select>';
	}

	public function groupedDropDown( $args ) {
		$name      = $args['option_name'];
		$label     = $args['label_for'];
		$groups    = $args['options'];
		$eleName   = $name . "[$label]";
		$className = ' class="' . $args['html_class'] . '"';
		$htmlId    = $args['html_id'] ? ' id="' . $args['html_id'] . '"' : '';

		echo "<select $htmlId $className name=\"$eleName\">";

		foreach ( $groups as $group => $options ) {
			echo "<optgroup label=\"$group\">";

			foreach ( $options as $option ) {
				$option_name = $option['name'];
				$option_id   = str_replace( ' ', '_', $option_name );
				$has_options = $option['has_options'] == 'true';

				echo "<option data-has-options='$has_options' value=$option_id>$option_name</option>";
			}

			echo "</optgroup>";
		}

		echo "</select>";
	}

	/**
	 * Output a table row text field with a given label, name, and value
	 *
	 * @param $label
	 * @param $name
	 * @param $value
     * @param $rowClass
	 * @param bool $hidden
	 */
	public function formTextRow( $label, $name, $value, $rowClass = '', $hidden = false ) {
		?>
        <tr class="<?= $rowClass ?> <?= $hidden ? 'hidden' : '' ?>">
            <th scope="row">
                <label for="<?= $name ?>"><?= $label ?></label>
            </th>
            <td>
                <input type="text" class="regular-text" name="<?= $name ?>>" value="<?= $value ?>"
                       required>
            </td>
        </tr>
		<?php
	}

	/**
	 * Output a table row textarea with a given label, name, and value
	 *
	 * @param $label
	 * @param $name
	 * @param $value
     * @param $rowClass
	 * @param bool $hidden
	 */
	public function formTextArea( $label, $name, $value, $rowClass = '', $hidden = false ) {
		?>
        <tr class="<?= $rowClass ?> <?= $hidden ? 'hidden' : '' ?>">
            <th scope="row">
                <label for="<?= $name ?>"><?= $label ?>></label>
            </th>
            <td>
                <textarea rows="4" type="text" class="regular-text" name="<?= $name ?>>" value="<?= $value ?>"
                       required>
                    <?= $value ?>
                </textarea>
            </td>
        </tr>
		<?php
	}

	/**
	 * Output a table row that holds the control type dropdown.
	 */
	public function formControlTypeDropdown() {
		?>
        <tr>
            <th scope="row">
                <label for="control_type">Control Type</label>
            </th>
            <td>
                <select id="dropdown_control_type" class="dropdown_control_type" name="control_type">
					<?php $options = AdminSettingsService::getControlTypeOptions() ?>
					<?php foreach ( $options as $optionGroup => $groupOptions ): ?>
                        <optgroup label="<?= $optionGroup ?>">
							<?php foreach ( $groupOptions as $groupOption ): ?>
                                <option data-has-options="<?= array_key_exists( 'has_options', $groupOption ) ? $groupOption['has_options'] : 0 ?>"
                                        value="<?= $groupOption['name'] ?>">
									<?= $groupOption['name'] ?>
                                </option>
							<?php endforeach; ?>
                        </optgroup>
					<?php endforeach; ?>
                </select>
            </td>
        </tr>
		<?php
	}
}