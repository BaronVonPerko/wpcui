<div class="wrap">
    <h1>WPCUI Options</h1>

	<?php settings_errors(); ?>

    <?php $options = get_option( 'wpcui_options' ) ?: array(); ?>

    <form method="post" action="options.php">
        <form method="post" action="options.php">
		    <?php
		    settings_fields( 'wpcui' );
		    do_settings_sections( 'wpcui' );
		    submit_button('Create New Section');
		    ?>
        </form>
    </form>
</div>
