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
	public static function getSections() {
		return get_option( 'wpcui_sections' );
	}

	public static function setSections( $sections ) {
		update_option( 'wpcui_sections', $sections );
	}

	public static function getNextSectionId() {
		return get_option( 'wpcui_section_index' ) + 1;
	}

	public static function updateNextSectionId() {
		update_option( 'wpcui_section_index', self::getNextSectionId() );
	}

	public static function getSectionIdByName( $sectionName ) {
		foreach ( self::getSections() as $key => $section ) {
			if ( $section['section_title'] == $sectionName ) {
				return $key;
			}
		}

		return - 1;
	}

	public static function deleteSection( $sectionName ) {
		$id = DataService::getSectionIdByName( $sectionName );

		$sections = self::getSections();

		unset( $sections[ $id ] );

		return $sections;
	}

	public static function getControls() {
		return get_option( 'wpcui_controls' );
	}

	public static function setControls( $controls ) {
		update_option( 'wpcui_controls', $controls );
	}

	/**
	 * Change the name of a section.
	 *
	 * @param $oldName
	 * @param $newName
	 * @param $data
	 *
	 * @return array
	 */
	public static function updateSectionName( $oldName, $newName, $data ) {
		$output = [];

		foreach ( $data as $key => $datum ) {
			if ( $key == $oldName ) {
				$datum['section_title'] = $newName;
				$output[ $newName ]     = $datum;
			} else {
				$output[ $key ] = $datum;
			}
		}

		return $output;
	}

	/**
	 * Set default options in the database
	 */
	public static function setDefaults() {
		self::setControls( [] );
		self::setSections( [] );

		update_option( 'wpcui_section_index', 0 );
	}
}