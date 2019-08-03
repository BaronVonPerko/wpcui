<?php

namespace Inc\Services;

class DataService {
	public static function getSections() {
		return get_option( 'wpcui_sections' );
	}

	public static function setSections( $sections ) {
		update_option( 'wpcui_sections', $sections );
	}

	public static function getNextSectionId() {
		return get_option('wpcui_section_index') + 1;
	}

	public static function updateNextSectionId() {
		update_option('wpcui_section_index', self::getNextSectionId());
	}

	public static function getSectionIdByName( $sectionName ) {
		foreach(self::getSections() as $key => $section) {
			if($section['section_title'] == $sectionName) return $key;
		}
		return -1;
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
		$arrays = [ 'wpcui_sections', 'wpcui_controls' ];
		foreach ( $arrays as $option ) {
			if ( ! get_option( $option ) ) {
				update_option( $option, [] );
			}
		}

		update_option( 'wpcui_section_index', 0 );
	}
}