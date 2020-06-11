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

			if ( ! empty( self::getSectionById( $testTitle ) ) ) {
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

			if ( ! empty( self::getControlById( $testId ) ) ) {
				$newControlId = $testId;
			}

			$num ++;
		}

		$control->id = $newControlId;

		return $control;
	}

	/**
	 * Get the control by id
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
	 * Get the section by ID
	 *
	 * @param $sectionId
	 *
	 * @return mixed
	 */
	public static function getSectionById( $sectionId ) {
		return self::getSections()[ $sectionId ];
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
		$core = CoreSections::get();

		// update with what is in the database
		foreach ( $core as &$coreSection ) {
			if ( array_key_exists( $coreSection->id, (array) $sections ) ) {
				$coreSection->priority = $sections[ $coreSection->id ]['priority'];
				$coreSection->visible  = $sections[ $coreSection->id ]['visible'];
			}
		}

		return $core;
	}

	/**
	 * Convert a string to ID format (lowercase and spaces replaced
	 * with underscores).
	 *
	 * @param $string
	 *
	 * @return string|string[]
	 */
	public static function convertStringToId( $string ) {
		return str_replace( ' ', '_', strtolower( $string ) );
	}

	/**
	 * Add a new section to the settings object.
	 *
	 * @param $settings
	 * @param $title
	 */
	public static function createNewSection( &$settings, $title ) {
		$section = new CustomizerSection( $title, 99 );

		$settings['sections'][ $section->id ] = $section;
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