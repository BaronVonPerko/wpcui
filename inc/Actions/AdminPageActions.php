<?php

namespace PerkoCustomizerUI\Actions;

use PerkoCustomizerUI\Base\BaseController;

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

	public function register_actions() {
		add_action( 'wpcui_do_sample_control_code', [ $this, 'do_sample_control_code' ] );
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
			<textarea>get_theme_mod('<?= $controlId ?>', '<?= $controlDefault ? $controlDefault : "Default Value" ?>')</textarea>
			<span title="Copy code" class="wpcui-copy-icon dashicons dashicons-admin-page"></span>
		</pre>
		<?php
	}

}