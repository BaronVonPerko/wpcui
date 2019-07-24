<div class="wrap">
    <h1>WPCUI Options</h1>

	<?php settings_errors(); ?>

	<?php $options = get_option( 'wpcui_options' ) ?: array(); ?>

    <form method="post" action="options.php">
        <form method="post" action="options.php">
			<?php
			settings_fields( 'wpcui' );
			do_settings_sections( 'wpcui' );
			submit_button( 'Create New Section' );
			?>
        </form>
    </form>


    <table class="wp-list-table widefat">
		<?php $sections = get_option( 'wpcui_sections' ); ?>

        <thead>
        <tr>
            <th class="manage-column">Name</th>
            <th></th>
        </tr>
        </thead>

        <tbody>
		<?php foreach ( $sections as $key => $section ) : ?>
            <tr class="<?= array_search( $key, array_keys( $sections ) ) % 2 == 0 ? 'alternate' : '' ?>">
                <td><?= $section['section_title'] ?></td>
                <td>
                    <form action="options.php" method="post">
                        <input type="hidden" name="remove" value="<?= $section['section_title'] ?>">
						<?php settings_fields( 'wpcui' ); ?>
						<?php submit_button( 'Delete', 'delete small', 'submit', false, [
						        'onclick' => 'return confirm("Are you sure you want to delete this section?")'
                        ] ); ?>
                    </form>
                </td>
            </tr>
		<?php endforeach; ?>
        </tbody>
    </table>


</div>
