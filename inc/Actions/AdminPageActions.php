<?php

namespace PerkoCustomizerUI\Actions;

use PerkoCustomizerUI\Base\BaseController;
use PerkoCustomizerUI\Services\DataService;
use PerkoCustomizerUI\Services\FormControlsService;

/**
 * Class AdminPageActions
 * @package PerkoCustomizerUI\Actions
 *
 * Custom action hooks used on the Admin page.
 */
class AdminPageActions extends BaseController {

	public function register() {
		add_action( 'admin_init', [ $this, 'register_actions' ] );
	}

	/**
	 * Register all of the action hooks with WordPress
	 */
	public function register_actions() {
		add_action( 'wpcui_do_sample_control_code', [ $this, 'do_sample_control_code' ] );
		add_action( 'wpcui_do_edit_section_form', [ $this, 'do_edit_section_form' ] );
		add_action( 'wpcui_do_section_action_buttons', [ $this, 'do_section_action_buttons' ] );
		add_action( 'wpcui_do_control_action_buttons', [ $this, 'do_control_action_buttons' ] );
		add_action( 'wpcui_do_control_form', [ $this, 'do_control_form' ] );
		add_action( 'wpcui_do_new_section_form', [ $this, 'do_new_section_form' ] );
	}

	/**
	 * Generate the HTML to show the example PHP code used for
	 * using the customizer setting.
	 *
	 * @param $args
	 */
	public function do_sample_control_code( $args ) {
		$controlId      = esc_attr( $args['control_id'] );
		$controlDefault = esc_attr( $args['control_default'] );
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
	public function do_edit_section_form( $sectionTitle ) {
		?>
        <form action="options.php" method="post">
            <input type="hidden" name="wpcui_action" value="update_section_title">
            <input type="hidden" name="edit_section" value="<?= $sectionTitle ?>">
            <input type="hidden" name="old_title" value="<?= $sectionTitle ?>">
            <input type="hidden" name="edit_section" value="<?= $sectionTitle ?>">
            <input type="text" name="new_title" value="<?= $sectionTitle ?>"/>
			<?php settings_fields( 'wpcui' ); ?>
			<?php submit_button( 'Save Changes', 'small', 'edit', false, [ 'id' => 'submitEditSectionTitle' ] ); ?>
        </form>
        <form action="" method="post">
            <input type="hidden" name="edit_section" value="">
			<?php settings_fields( 'wpcui' ); ?>
			<?php submit_button( 'Cancel', 'small', 'edit', false, [ 'id' => 'submitCancelEditSectionTitle' ] ); ?>
        </form>
		<?php
	}


	/**
	 * Create the Edit and Delete action buttons for a Section
	 *
	 * @param $args [sectionId, sectionTitle]
	 */
	public function do_section_action_buttons( $args ) {
		$editSectionId = $args[0];
		$sectionTitle  = $args[1];
		?>
        <form action="" method="post">
            <input type="hidden" name="<?= $editSectionId ?>" value="<?= $sectionTitle ?>">
			<?php settings_fields( 'wpcui' ); ?>
			<?php submit_button( 'Edit', 'small', 'edit', false, [ 'id' => 'submitEditSection' ] ); ?>
        </form>

        <form action="options.php" method="post" style="margin-right: 5px;">
            <input type="hidden" name="section_title" value="<?= $sectionTitle ?>">
            <input type="hidden" name="wpcui_action" value="delete_section">
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
	public function do_control_action_buttons( $controlId ) {
		?>
        <form action="" method="post" style="margin-right: 5px;">
            <input type="hidden" name="edit_control_id" value="<?= $controlId ?>">
			<?php settings_fields( 'wpcui' ); ?>
			<?php submit_button( 'Edit', 'small', 'edit', false, [ 'id' => 'submitEditControl' ] ); ?>
        </form>

        <form action="options.php" method="post">
            <input type="hidden" name="control_id" value="<?= $controlId ?>">
            <input type="hidden" name="wpcui_action" value="delete_control">
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
	public function do_control_form( $sectionKey ) {
		$action = array_key_exists( 'edit_control_id', $_POST ) ? 'update_control' : 'create_new_control';
		?>
        <form method="post" action="options.php" class="wpcui-control-form">
            <input type="hidden" name="section" value="<?= $sectionKey ?>">
            <input type="hidden" name="wpcui_action" value="<?= $action ?>">
			<?php
			settings_fields( 'wpcui' );
			do_settings_sections( 'wpcui-control' );
			if ( array_key_exists( 'edit_control_id', $_POST ) ) {
				submit_button( 'Update Control', 'primary', 'submit', true, [ 'id' => 'submitUpdateControl' ] );
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
	public function do_new_section_form() {
		?>
        <form method="post" action="options.php">
            <input type="hidden" name="wpcui_action" value="create_new_section">
			<?php
			settings_fields( 'wpcui' );
			do_settings_sections( 'wpcui' );
			submit_button( 'Create New Section', 'primary', 'submit', true, [ 'id' => 'submitNewSection' ] );
			?>
        </form>
		<?php
	}

}