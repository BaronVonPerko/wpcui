<?php

namespace PerkoCustomizerUI\Data;

/**
 * Class DataService
 * @package PerkoCustomizerUI\Services
 *
 * The purpose of this service is to retrieve and update
 * data in the database.
 */
class DataService {

	public static function setSettings( $settings ) {
		update_option( 'wpcui_settings', $settings );
	}

	public static function getSections() {
		if ( array_key_exists( 'sections', self::getSettings() ) ) {
			$sectionsArr = self::getSettings()['sections'];

			return DataConverters::ConvertSections( $sectionsArr );
		} else {
			return [];
		}
	}

	public static function getSettings() {
		return get_option( 'wpcui_settings' );
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
	 * TODO: v2.1
	 */
	private static function getCoreSectionsData() {
//		return self::getSettings()["core_sections"];
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
	 * Get the control id prefix from the settings.
	 *
	 * @return string
	 */
	public static function getControlIdPrefix() {
		$settings = self::getSettings()['settings'];

		return array_key_exists( 'controlPrefix', $settings ) ? $settings['controlPrefix'] : '';
	}
}