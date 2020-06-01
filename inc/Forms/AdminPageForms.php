<?php

namespace PerkoCustomizerUI\Forms;

use PerkoCustomizerUI\Base\BaseController;
use PerkoCustomizerUI\Services\AdminFormStatus;
use PerkoCustomizerUI\Services\AdminFormStatusService;

/**
 * Class AdminPageActions
 * @package PerkoCustomizerUI\Actions
 *
 * Custom action hooks used on the Admin page.
 */
class AdminPageForms extends BaseController {

	public function register() {
		//
	}

	/**
	 * Get the control ID.  Add the prefix if there is one.
	 *
	 * @param $control
	 * @param $settings
	 *
	 * @return string
	 */
	public static function GetControlId( $control, $settings ): string {
		$prefix = '';

		if ( array_key_exists( 'control_prefix', $settings ) && ! empty( $settings['control_prefix'] ) ) {
			$prefix = $settings['control_prefix'] . '_';
		}

		return $prefix . esc_attr( $control['control_id'] );
	}

	/**
	 * Generate the HTML to show the example PHP code used for
	 * using the customizer setting.
	 *
	 * @param $controlId
	 * @param $controlDefault
	 */
	public static function SampleControlCode( $controlId, $controlDefault ) {
		$controlDefault = esc_attr( $controlDefault );
		?>
        <pre class="wpcui-sample-php">
			<textarea>get_theme_mod( '<?= $controlId ?>', '<?= $controlDefault ? $controlDefault : "Default Value" ?>' )</textarea>
        <span title="Copy code" class="wpcui-copy-icon dashicons dashicons-admin-page"></span>
        </pre>
		<?php
	}


	/**
	 * Given a section title, create the edit form.
	 *
	 * @param $sectionTitle
	 */
	public static function EditSectionForm( $sectionTitle ) {
		?>
        <form action="options.php" method="post">
			<?= self::FormAction( AdminPageFormActions::UpdateSection ); ?>
            <input type="hidden" name="old_title" value="<?= $sectionTitle ?>">
            <input type="text" name="new_title" value="<?= $sectionTitle ?>"/>
			<?php settings_fields( 'wpcui' ); ?>
			<?php submit_button( 'Save Changes', 'small primary', 'edit', false,
				[ 'id' => 'submitEditSectionTitle' ] ); ?>
			<?php self::CancelButton( 'submitEditCancelButton', 'small' ); ?>
        </form>
		<?php
	}


	/**
	 * Create the Edit and Delete action buttons for a Section
	 *
	 * @param $editSectionId
	 * @param $sectionTitle
	 */
	public static function SectionActionButtons( $editSectionId, $sectionTitle ) {
		?>
        <form action="" method="post">
            <input type="hidden" name="<?= $editSectionId ?>" value="<?= $sectionTitle ?>">
			<?php settings_fields( 'wpcui' ); ?>
			<?php submit_button( 'Edit', 'small', 'edit', false, [ 'id' => 'submitEditSection' ] ); ?>
        </form>

        <form action="options.php" method="post" style="margin-right: 5px;">
			<?= self::FormAction( AdminPageFormActions::DeleteSection ); ?>
            <input type="hidden" name="section_title" value="<?= $sectionTitle ?>">
			<?php settings_fields( 'wpcui' ); ?>
			<?php submit_button( 'Delete', 'delete small', 'submit', false, [
				'onclick' => 'return confirm("Are you sure you want to delete this section?")',
				'id'      => 'submitDeleteSection'
			] ); ?>
        </form>
		<?php
	}


	/**
	 * Given a control id, create the Delete action button.
	 *
	 * @param $controlId
	 */
	public static function ControlActionButtons( $controlId ) {
		?>
        <form action="" method="post" style="margin-right: 5px;">
            <input type="hidden" name="<?= AdminFormStatus::EditControl ?>" value="<?= $controlId ?>">
			<?php settings_fields( 'wpcui' ); ?>
			<?php submit_button( 'Edit', 'small', 'edit', false, [ 'id' => 'submitEditControl' ] ); ?>
        </form>

        <form action="options.php" method="post">
			<?= self::FormAction( AdminPageFormActions::DeleteControl ); ?>
            <input type="hidden" name="control_id" value="<?= $controlId ?>">
			<?php settings_fields( 'wpcui' ); ?>
			<?php submit_button( 'Delete', 'delete small', 'submit', false, [
				'onclick' => 'return confirm("Are you sure you want to delete this control?")',
				'id'      => 'submitDeleteControl_' . $controlId
			] ); ?>
        </form>
		<?php
	}


	/**
	 * Given the section key, create the form to create/edit a control.
	 *
	 * @param $sectionKey
	 */
	public static function ControlForm( $sectionKey ) {
		$action = AdminFormStatusService::IsEditControlForSection( $sectionKey )
			? AdminPageFormActions::UpdateControl
			: AdminPageFormActions::CreateControl;
		?>
        <form method="post" action="options.php" class="wpcui-control-form">
			<?= self::FormAction( $action ); ?>
            <input type="hidden" name="section" value="<?= $sectionKey ?>">
            <input type="hidden" name="old_control_id"
                   value="<?= sanitize_text_field( $_POST[ AdminFormStatus::EditControl ] ) ?>">
			<?php
			settings_fields( 'wpcui' );
			do_settings_sections( 'wpcui-control' );
			if ( AdminFormStatusService::IsEditControlForSection( $sectionKey ) ) {
				submit_button( 'Update Control', 'primary', 'submit', false, [ 'id' => 'submitUpdateControl' ] );
				self::CancelButton( 'submitCancelEditControl' );
			} else {
				submit_button( 'Create New Control', 'primary', 'submit', true, [ 'id' => 'submitCreateNewControl' ] );
			}
			?>
        </form>
		<?php
	}


	/**
	 * Create the form to create a new section
	 */
	public static function NewSectionForm() {
		?>
        <form method="post" action="options.php">
            <input type="hidden" name="wpcui_action" value="<?= AdminPageFormActions::CreateNewSection ?>">
			<?php
			settings_fields( 'wpcui' );
			do_settings_sections( 'wpcui' );
			submit_button( 'Create New Section', 'primary', 'submit', true, [ 'id' => 'submitNewSection' ] );
			?>
        </form>
		<?php
	}


	/**
	 * Set the form action
	 *
	 * @param $action
	 */
	private static function FormAction( $action ) {
		?>
        <input type="hidden" name="wpcui_action" value=<?= $action ?>>
		<?php
	}


	private static function CancelButton( $id, $classes = '' ) {
		submit_button( 'Cancel', 'secondary wpcui-btn-cancel ' . $classes, 'cancel', false, [ 'id' => $id ] );
	}

}

abstract class AdminPageFormActions {
	const CreateNewSection = 0;
	const DeleteSection = 1;
	const UpdateSection = 2;
	const CreateControl = 3;
	const UpdateControl = 4;
	const DeleteControl = 5;
}