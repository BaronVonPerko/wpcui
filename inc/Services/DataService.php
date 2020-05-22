<?php

namespace PerkoCustomizerUI\Services;

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
				if ( $control['id'] == $controlId ) {
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
		$sections = self::getSettings()['sections'];
		foreach ( $sections as $section ) {
			foreach ( $section['controls'] as $control ) {
				if ( $control['control_id'] == $controlId ) {
					return $control;
				}
			}
		}

		return null;
	}

	/**
	 * Set default options in the database
	 */
	public static function setDefaults() {
		self::setSettings( [] );

		update_option( 'wpcui_section_index', 0 );
	}
}