<?php

namespace Inc\Services;

class DataService {
	public static function getSections() {
		return get_option( 'wpcui_sections' );
	}

	public static function getControls() {
		return get_option( 'wpcui_controls' );
	}

	public static function setControls( $controls ) {
		update_option( 'wpcui_controls', $controls );
	}

	/**
	 * Since we cannot update the options during the sanitize step,
	 * this function will run on admin_init.  It will go through the
	 * existing sections, and delete any controls that are no longer
	 * associated with a section.
	 */
	public static function cleanDatabase() {
		$sections = self::getSections();
		$controls = self::getControls();

		// find the valid controls
		$validControls = [];
		foreach ( $controls as $key => $control ) {
			if ( array_key_exists( $control['section'], $sections ) ) {
				$validControls[ $key ] = $control;
			}
		}

		$updatedSections = array_filter($sections, function($section) {
			return array_key_exists('old_name', $section);
		});

		foreach($updatedSections as $sectionKey => $updatedSection) {
			$controlsToUpdate = array_filter($controls, function($control) use ($updatedSection) {
				return $control['section'] == $updatedSection['old_name'];
			});

			foreach ($controlsToUpdate as $key => $controlToUpdate) {
				$controlToUpdate['section'] = $sectionKey;
				$validControls[$key] = $controlToUpdate;
			}
		}

		// update the database
		self::setControls( $validControls );
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
		foreach($data as $key=>$datum) {
			if($key == $oldName) {
				$datum['section_title'] = $newName;
				$datum['old_name'] = $oldName;
				$output[$newName] = $datum;
			} else {
				$output[$key] = $datum;
			}
		}

		return $output;
	}

	/**
	 * Set default options in the database
	 */
	public static function setDefaults() {
		$options = [ 'wpcui_sections', 'wpcui_controls' ];
		foreach ( $options as $option ) {
			if ( ! get_option( $option ) ) {
				update_option( $option, [] );
			}
		}
	}
}