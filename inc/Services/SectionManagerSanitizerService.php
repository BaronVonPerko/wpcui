<?php

namespace PerkoCustomizerUI\Services;

/**
 * Class SectionManagerSanitizerService
 * @package PerkoCustomizerUI\Services
 *
 * Service for sanitizing form requests from the Settings page
 */
class SectionManagerSanitizerService {

	public function sanitizeSectionManager( $input ) {
		foreach ( $input['sections'] as &$section ) {
			$id = DataService::getSectionIdFromTitle( $section['section_title'] );
			if ( array_key_exists( "section_priority_$id", $_POST ) ) {
				$section['priority'] = sanitize_text_field( $_POST["section_priority_$id"] );
			}

			$section['visible'] = array_key_exists( "section_visible_$id", $_POST ) ? true : false;
		}

		foreach ( DataService::getCoreSections() as $coreSection ) {
			if ( array_key_exists( "section_priority_$coreSection->id", $_POST ) ) {
				$input["core_sections"][ $coreSection->id ]["priority"] = sanitize_text_field( $_POST["section_priority_$coreSection->id"] );
				$input["core_sections"][ $coreSection->id ]["visible"]  = array_key_exists( "section_visible_$coreSection->id", $_POST ) ? true : false;
			}
		}

		return $input;
	}

}