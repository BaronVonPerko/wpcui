<?php

namespace PerkoCustomizerUI\Data;

use PerkoCustomizerUI\Classes\CustomizerControl;
use PerkoCustomizerUI\Classes\CustomizerSection;

/**
 * Class DataConverters
 * @package PerkoCustomizerUI\Services
 *
 * The purpose of this service is to convert data from the
 * array stored in the database (via JSON through API calls)
 * into class objects.
 */
class DataConverters {

    public static function ConvertSection($section): CustomizerSection {
        $controls = self::ConvertControls($section['controls']);

        return new CustomizerSection(
            $section['title'],
            $section['priority'],
            $controls,
            $section['visible']
        );
    }

    public static function ConvertSections($sectionsArr): array
    {
        $sections = [];

        foreach ($sectionsArr as $section) {
            $sections[] = self::ConvertSection($section);
        }

        return $sections;
    }

    public static function ConvertControl($control): CustomizerControl {
        return new CustomizerControl(
            $control['id'],
            $control['label'],
            $control['type'],
            $control['default'],
            $control['choices']
        );
    }

    public static function ConvertControls($controlsArr): array {
        $controls = [];

        foreach ($controlsArr as $control) {
            $controls[] = self::ConvertControl($control);
        }

        return $controls;
    }

}