<div class="wrap">
	<?php settings_errors(); ?>

    <h1>Customizer UI Settings</h1>

    <form method="post" action="options.php">
		<?php
		settings_fields( 'wpcui' );
		do_settings_sections( 'wpcui-settings' );
		submit_button( 'Save', 'primary', 'submit', true );
		?>
    </form>
</div>