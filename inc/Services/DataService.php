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
	 * Get the core sections and their priorities
	 */
	public static function getCoreCustomizerSections() {
		return [
			new CustomizerSection( 'title_tagline', 'Site Identity', 20, [] ),
			new CustomizerSection( 'colors', 'Colors', 40, [] ),
			new CustomizerSection( 'header_image', 'Header Image', 60, [] ),
			new CustomizerSection( 'background_image', 'Background Image', 80, [] ),
			new CustomizerSection( 'static_front_page', 'Homepage Settings', 100, [] ),
			new CustomizerSection( 'custom_css', 'Additional CSS', 200, [] ),
		];
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
		$id       = self::getSectionIdFromTitle( $title );
		$priority = array_key_exists( 'priority', $section ) ? $section['priority'] : 99;
		$controls = self::normalizeControls( $section['controls'] );

		return new CustomizerSection( $id, $title, $priority, $controls );
	}


	public static function getSectionIdFromTitle( $title ) {
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
		$coreSections  = DataService::getCoreCustomizerSections();
		$wpcuiSections = DataService::getSections();
		$sections      = array_merge( $coreSections, $wpcuiSections );
		usort( $sections, function ( $a, $b ) {
			return $a->priority - $b->priority;
		} );

		return $sections;
	}
}