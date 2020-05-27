<?php

namespace PerkoCustomizerUI\Services;

class AdminFormStatusService {

	/**
	 * Are we in a cancel state?
	 *
	 * @return bool
	 */
	public static function IsCancel() {
		return isset( $_POST[ AdminFormStatus::Cancel ] );
	}


	/**
	 * Is the given section in edit mode?
	 *
	 * @param $sectionId
	 *
	 * @return bool
	 */
	public static function IsEditSectionTitle( $sectionId ) {
		return isset( $_POST[ $sectionId ] );
	}


	/**
	 * Are we in an edit control mode?
	 *
	 * @return bool
	 */
	public static function IsEditControl() {
		return isset( $_POST[ AdminFormStatus::EditControl ] );
	}


	/**
	 * Is the given section in edit control mode?
	 *
	 * @param $sectionId
	 *
	 * @return bool
	 */
	public static function IsEditControlForSection( $sectionId ) {
		if ( isset( $_POST[ AdminFormStatus::EditControl ] ) ) {
			$control = DataService::getControlById( $_POST[ AdminFormStatus::EditControl ] );

			return $control['section'] == $sectionId;
		}

		return false;
	}

}


abstract class AdminFormStatus {
	const Cancel = 'cancel';
	const EditControl = 'edit_control';
}