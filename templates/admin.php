<div class="wrap">
    <h1>WPCUI Options</h1>

	<?php settings_errors(); ?>

	<?php $options = get_option( 'wpcui_options' ) ?: array(); ?>

    <form method="post" action="options.php">
		<?php
		settings_fields( 'wpcui' );
		do_settings_sections( 'wpcui' );
		submit_button( 'Create New Section' );
		?>
    </form>

	<?php
	$sections = get_option( 'wpcui_sections' );
	$controls = get_option( 'wpcui_controls' );
	?>

	<?php if ( count( $sections ) > 0 ): ?>
        <table class="wp-list-table widefat">

            <thead>
            <tr>
                <th class="manage-column">Name</th>
                <th></th>
            </tr>
            </thead>

            <tbody>
			<?php foreach ( $sections as $key => $section ) : ?>

                <!-- Row for the section and section buttons -->
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

                        <form action="options.php" method="post">
                            <input type="hidden" name="edit" value="<?= $section['section_title'] ?>">
							<?php settings_fields( 'wpcui' ); ?>
							<?php submit_button( 'Edit', 'small', 'edit' ); ?>
                        </form>
                    </td>
                </tr>

				<?php
				$sectionControls = array_filter( $controls, function ( $control ) use ( $key ) {
					return $control["section"] == $key;
				} );
				?>

            <?php if(count($sectionControls) == 0): ?>
                <tr class="<?= array_search( $key, array_keys( $sections ) ) % 2 == 0 ? 'alternate' : '' ?>">
                    <td colspan="2">
                        <em>There are currently no controls for this section.</em>
                    </td>
                </tr>
            <?php endif; ?>

                <!-- Row that will contain the sub-table, showing the controls within each section -->
				<?php if ( count( $sectionControls ) > 0 ) : ?>
                    <tr class="<?= array_search( $key, array_keys( $sections ) ) % 2 == 0 ? 'alternate' : '' ?>">
                        <td colspan="2">
                            <table class="wp-list-table">
                                <thead>
                                <tr>
                                    <th class="manage-column">Control ID</th>
                                    <th class="manage-column">Control Label</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach($sectionControls as $control): ?>
                                <tr>
                                    <td><?= $control['control_id'] ?></td>
                                    <td><?= $control['control_label'] ?></td>
                                </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </td>
                    </tr>
				<?php endif; ?>


                <!-- Row that will contain the form for creating a new control -->
                <tr class="<?= array_search( $key, array_keys( $sections ) ) % 2 == 0 ? 'alternate' : '' ?>">
                    <td colspan="2">
                        <form method="post" action="options.php">
                            <input type="hidden" name="section" value="<?= $key ?>">
		                    <?php
		                    settings_fields( 'wpcui-control' );
		                    do_settings_sections( 'wpcui-control' );
		                    submit_button( 'Create New Control' );
		                    ?>
                        </form>
                    </td>
                </tr>

			<?php endforeach; ?>
            </tbody>
        </table>
	<?php endif; ?>

</div>
