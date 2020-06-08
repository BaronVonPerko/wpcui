<?php

namespace PerkoCustomizerUI\Services;

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

	public static function getSections( $normalized = true ) {
		$sections = self::getSettings()['sections'];

		return $normalized ? self::normalizeSections( $sections ) : $sections;
	}

	public static function setSettings( $sections ) {
		update_option( 'wpcui_settings', $sections );
	}

	public static function getNextSectionId() {
		return get_option( 'wpcui_section_index' ) + 1;
	}

	public static function createNewSection( &$settings, $title, $controls = [] ) {
		$id                                      = self::getNextSectionId();
		$settings['sections'][ $id ]             = [ "section_title" => $title ];
		$settings['sections'][ $id ]['controls'] = $controls;
		DataService::updateNextSectionId();
	}

	public static function convertControlsToArray( $controls ) {
		foreach ( $controls as &$control ) {
			$control = [
				"control_id"      => $control->id,
				"control_label"   => $control->label,
				"control_type"    => $control->type,
				"control_choices" => $control->choices,
				"control_default" => $control->default,
				"section"         => $control->section_id
			];
		}

		return $controls;
	}

	public static function updateNextSectionId() {
		update_option( 'wpcui_section_index', self::getNextSectionId() );
	}

	public static function getSectionIdByName( $sectionName ) {
		foreach ( self::getSettings()['sections'] as $key => $section ) {
			if ( $section['section_title'] == $sectionName ) {
				return $key;
			}
		}

		return - 1;
	}

	public static function getSectionByName( $sectionName ) {
		foreach ( self::getSettings()['sections'] as $section ) {
			if ( $section['section_title'] == $sectionName ) {
				return $section;
			}
		}

		return - 1;
	}

	/**
	 * Create a duplicate of a section.  All controls
	 * must also be duplicated with unique IDs.
	 *
	 * @param $sectionName
	 *
	 * @return null
	 */
	public static function duplicateSection( $sectionName ) {
		$section = self::getSectionByName( $sectionName );
		$section = self::normalizeSection( $section );

		$newSectionTitle = '';
		$num             = 1;
		while ( empty( $newSectionTitle ) ) {
			$testTitle = $sectionName . " $num";

			if ( ! self::checkSectionExists( $testTitle ) ) {
				$newSectionTitle = $testTitle;
			}

			$num ++;
		}

		return new CustomizerSection(
			self::createSectionIdFromTitle( $newSectionTitle ),
			$newSectionTitle,
			$section->priority,
			self::convertControlsToArray( self::duplicateControls( $section->controls ) )
		);
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

			$id = $duplicatedControl->id;

			$duplicatedControls[ $id ] = $duplicatedControl;
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
		$sections = self::getSettings()['sections'];
		foreach ( $sections as $section ) {
			foreach ( $section['controls'] as $control ) {
				if ( $control['control_id'] == $controlId ) {
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
		$prefix = self::getControlIdPrefix();
		if ( ! empty( $prefix ) ) {
			$prefix .= '_';
		}

		$sections = self::getSettings()['sections'];
		foreach ( $sections as $section ) {
			foreach ( $section['controls'] as $control ) {
				if ( $prefix . $control['control_id'] == $controlId ) {
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
			if ( array_key_exists( $coreSection->id, $sections ) ) {
				$coreSection->priority = $sections[ $coreSection->id ]['priority'];
				$coreSection->visible  = $sections[ $coreSection->id ]['visible'];
			}
		}

		return $core;
	}


	/**
	 * Convert the database array of sections into CustomizerSection objects
	 *
	 * @param $sections
	 *
	 * @return array|string
	 */
	public static function normalizeSections( $sections ) {
		$result = [];

		foreach ( $sections as $section ) {
			$result[] = self::normalizeSection( $section );
		}

		return $result;
	}

	/**
	 * Normalize a single section.
	 *
	 * @param $section
	 *
	 * @return object
	 */
	public static function normalizeSection( $section ) {
		$title    = $section['section_title'];
		$id       = self::createSectionIdFromTitle( $title );
		$priority = array_key_exists( 'priority', $section ) ? $section['priority'] : 99;
		$controls = self::normalizeControls( $section['controls'] );
		$visible  = array_key_exists( 'visible', $section ) ? $section['visible'] : true;

		return new CustomizerSection( $id, $title, $priority, $controls, $visible );
	}


	public static function createSectionIdFromTitle( $title ) {
		return str_replace( ' ', '_', strtolower( $title ) );
	}

	/**
	 * Normalize an array of controls
	 *
	 * @param $controls
	 *
	 * @return array
	 */
	public static function normalizeControls( $controls ) {
		$result = [];

		foreach ( $controls as $control ) {
			$result[] = self::normalizeControl( $control );
		}

		return $result;
	}

	/**
	 * Normalize a single control
	 *
	 * @param $control
	 *
	 * @return CustomizerControl
	 */
	public static function normalizeControl( $control ) {
		return new CustomizerControl(
			$control['control_id'],
			$control['control_label'],
			$control['control_id'],
			$control['section'],
			$control['control_type'],
			$control['control_default'],
			$control['control_choices']
		);
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