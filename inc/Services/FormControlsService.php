<?php

namespace Inc\Services;

class FormControlsService
{
    public function textField($args)
    {
        $name = $args['label_for'];
        $option_name = $args['option_name'];
        $value = '';

        echo '<input type="text" class="regular-text" id="' . $name . '" name="' . $option_name . '[' . $name . ']" value="' . $value . '" placeholder="' . $args['placeholder'] . '" required>';
    }

    public function textArea($args) {
        $name = $args['label_for'];
        $option_name = $args['option_name'];
        $value = '';
        $required = $args['required'] ? 'required' : '';

        echo '<textarea rows="4" class="regular-text" id="' . $name . '" name="' . $option_name . '[' . $name . ']" value="' . $value . '" placeholder="' . $args['placeholder'] . ' ' . $required . '"></textarea>';
    }

    public function dropDown($args)
    {
        $name = $args['option_name'];
        $label = $args['label_for'];

        $eleName = $name . "[$label]";
        echo "<select name=\"$eleName\">";

        foreach ($args['options'] as $option) {
            $option_id = str_replace(' ', '_', $option);
            echo "<option value=$option_id>$option</option>";
        }

        echo '</select>';
    }

    public function groupedDropDown($args)
    {
        $name = $args['option_name'];
        $label = $args['label_for'];
        $groups = $args['options'];
        $eleName = $name . "[$label]";
        $className = ' class="' . $args['html_class'] . '"';
        $htmlId = $args['html_id'] ? ' id="' . $args['html_id'] . '"' : '';

        echo "<select $htmlId $className name=\"$eleName\">";

        foreach($groups as $group => $options) {
            echo "<optgroup label=\"$group\">";

            foreach($options as $option) {
                $option_name = $option['name'];
                $option_id = str_replace(' ', '_', $option_name);
                $has_options = $option['has_options'] == 'true';

                echo "<option data-has-options='$has_options' value=$option_id>$option_name</option>";
            }

            echo "</optgroup>";
        }

        echo "</select>";
    }
}