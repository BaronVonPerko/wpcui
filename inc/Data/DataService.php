<?php

namespace PerkoCustomizerUI\Data;

use PerkoCustomizerUI\Classes\CustomizerControl;
use PerkoCustomizerUI\Classes\CustomizerSection;

/**
 * Class DataService
 * @package PerkoCustomizerUI\Services
 *
 * The purpose of this service is to retrieve and update
 * data in the database.
 */
class DataService {
	public static function getSettings() {
		return get_option( 'wpcui_settings' );
	}

	public static function getSections() {
		return self::getSettings()['sections'];
	}

	public static function getDatabaseVersion() {
		return self::getSettings()['db_version'];
	}

	public static function setSettings( $settings ) {
		update_option( 'wpcui_settings', $settings );
	}

	/**
	 * Create a duplicate of a section.  All controls
	 * must also be duplicated with unique IDs.
	 *
	 * @param $section CustomizerSection
	 *
	 * @return null
	 */
	public static function duplicateSection( $section ) {
		$newSectionTitle = '';

		$num = 1;
		while ( empty( $newSectionTitle ) ) {
			$testTitle = $section->title . " $num";

			if ( ! self::checkSectionExists( $testTitle ) ) {
				$newSectionTitle = $testTitle;
			}

			$num ++;
		}

		return new CustomizerSection(
			$newSectionTitle,
			$section->priority,
			self::duplicateControls( $section->controls )
		);
	}

	public static function insertNewSection( &$settings, $section ) {
		$settings['sections'][ $section->id ] = $section;
	}

	/**
	 * Duplicate an array of controls, changing each ID to a unique one
	 *
	 * @param $controls
	 *
	 * @return array
	 */
	public static function duplicateControls( $controls ) {
		$duplicatedControls = [];

		foreach ( $controls as $control ) {
			$duplicatedControl = self::duplicateControl( $control );

			$duplicatedControls[ $duplicatedControl->id ] = $duplicatedControl;
		}

		return $duplicatedControls;
	}

	/**
	 * Duplicate a single control, changing the ID to be unique
	 *
	 * @param $control
	 *
	 * @return mixed
	 */
	public static function duplicateControl( $control ) {
		$newControlId = '';

		$num = 1;

		while ( empty( $newControlId ) ) {
			$testId = $control->id . "_$num";

			if ( ! self::checkControlIdExists( $testId ) ) {
				$newControlId = $testId;
			}

			$num ++;
		}

		$control->id = $newControlId;

		return $control;
	}

	/**
	 * Check if a given control id is already being used.
	 *
	 * @param $controlId
	 *
	 * @return bool
	 */
	public static function checkControlIdExists( $controlId ) {
		$sections = self::getSections();

		foreach ( $sections as $section ) {
			foreach ( $section->controls as $control ) {
				if ( $control->id == $controlId ) {
					return true;
				}
			}
		}

		return false;
	}

	/**
	 * Check if a given section already exists.
	 *
	 * @param $sectionName
	 *
	 * @return bool
	 */
	public static function checkSectionExists( $sectionName ) {
		foreach ( self::getSections() as $section ) {
			if ( $section->title == $sectionName ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Get the control by it's id
	 *
	 * @param $controlId
	 *
	 * @return bool
	 */
	public static function getControlById( $controlId ) {
		$sections = self::getSections();
		foreach ( $sections as $section ) {
			foreach ( $section->controls as $control ) {
				if ( $control->id == $controlId ) {
					return $control;
				}
			}
		}

		return null;
	}

	/**
	 * Get the control id prefix from the settings.
	 *
	 * @return string
	 */
	public static function getControlIdPrefix() {
		$settings = self::getSettings();

		return array_key_exists( 'control_prefix', $settings ) ? $settings['control_prefix'] : '';
	}

	/**
	 * Set default options in the database
	 */
	public static function setDefaults() {
		self::setSettings( [] );

		update_option( 'wpcui_section_index', 0 );
	}


	/**
	 * Get the core sections saved in the database.
	 *
	 * @return mixed
	 */
	private static function getCoreSectionsData() {
		return self::getSettings()["core_sections"];
	}


	/**
	 * Get the core sections and their priorities.
	 * This function has hard-coded defaults from what is used in the
	 * core wp files.  They are overridden by what is saved
	 * in the database when set with the Section Manager page.
	 */
	public static function getCoreSections() {
		$sections = self::getCoreSectionsData();

		// default values
		$core = [
			new CustomizerSection( 'title_tagline', 'Site Identity (core)', 20, [] ),
			new CustomizerSection( 'colors', 'Colors (core)', 40, [] ),
			new CustomizerSection( 'header_image', 'Header Image (core)', 60, [] ),
			new CustomizerSection( 'background_image', 'Background Image (core)', 80, [] ),
			new CustomizerSection( 'static_front_page', 'Homepage Settings (core)', 100, [] ),
			new CustomizerSection( 'custom_css', 'Additional CSS (core)', 200, [] ),
		];

		// update with what is in the database
		foreach ( $core as &$coreSection ) {
			if ( array_key_exists( $coreSection->id, (array) $sections ) ) {
				$coreSection->priority = $sections[ $coreSection->id ]['priority'];
				$coreSection->visible  = $sections[ $coreSection->id ]['visible'];
			}
		}

		return $core;
	}

	public static function convertStringToId( $string ) {
		return str_replace( ' ', '_', strtolower( $string ) );
	}


	/**
	 * Get all available sections, WPCUI plus Core, sorted by priority.
	 * @return array
	 */
	public static function getAllAvailableSections() {
		$coreSections  = DataService::getCoreSections();
		$wpcuiSections = DataService::getSections();
		$sections      = array_merge( $coreSections, $wpcuiSections );

		usort( $sections, function ( $a, $b ) {
			return $a->priority - $b->priority;
		} );

		return $sections;
	}
}