<?php

namespace PerkoCustomizerUI\Data;

/**
 * Class DataValidators
 * @package PerkoCustomizerUI\Data
 */
class DataValidators {

	/**
	 * Validate to make sure that the control ID meets the requirements
	 * of the WP Customizer.
	 *
	 * @param $id
	 *
	 * @return bool|string
	 */
	public static function validateControlId( $id ) {
		if ( strpos( $id, ' ' ) ) {
			return 'Control ID must not contain spaces.';
		}

		if ( strpos( $id, '-' ) ) {
			return 'Control ID must not contain hyphens.  Use underscores instead.';
		}

		if ( ! empty( DataService::getControlById( $id ) ) ) {
			return "Control ID $id already exists.";
		}

		return false;
	}


	/**
	 * Validate to make sure that the section name is unique.
	 *
	 * @param $sectionName
	 *
	 * @return bool|string
	 */
	public static function validateSectionName( $sectionName ) {
		$id = DataService::convertStringToId( $sectionName );

		return ( ! empty ( DataService::getSectionById( $id ) ) )
			? "A section with this name already exists."
			: false;
	}

}