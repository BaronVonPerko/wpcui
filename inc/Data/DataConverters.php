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
            self::ConvertControlType($control['type']),
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

    /**
     * MUST MATCH ControlType.ts enum
     *
     * @param $typeVal
     * @return string
     */
    public static function ConvertControlType($typeVal): string {
        switch($typeVal) {
            case 0:
                return "Text";
            case 1:
                return "Text_Area";
            case 2:
                return "Dropdown_Pages";
            case 3:
                return "Email";
            case 4:
                return "URL";
            case 5:
                return "Number";
            case 6:
                return "Date";
            case 7:
                return "Select";
            case 8:
                return "Radio";
            case 9:
                return "Color_Picker";
            case 10:
                return "Upload";
            case 11:
                return "Image";
        }
    }

}