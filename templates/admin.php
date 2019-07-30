<div class="wrap">
    <h1>WPCUI Options</h1>

	<?php use Inc\Services\DataService;

	settings_errors(); ?>

    <form method="post" action="options.php">
		<?php
		settings_fields( 'wpcui' );
		do_settings_sections( 'wpcui' );
		submit_button( 'Create New Section' );
		?>
    </form>

	<?php
	$sections = DataService::getSections();
	$controls = DataService::getControls();
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
					<?php if ( ! isset( $_POST['edit_section'] ) ): ?>
                        <td><?= $section['section_title'] ?></td>
                        <td style="display: flex;">
                            <form action="options.php" method="post" style="margin-right: 5px;">
                                <input type="hidden" name="remove" value="<?= $section['section_title'] ?>">
								<?php settings_fields( 'wpcui' ); ?>
								<?php submit_button( 'Delete', 'delete small', 'submit', false, [
									'onclick' => 'return confirm("Are you sure you want to delete this section?")'
								] ); ?>
                            </form>

                            <form action="" method="post">
                                <input type="hidden" name="edit_section" value="<?= $section['section_title'] ?>">
								<?php settings_fields( 'wpcui' ); ?>
								<?php submit_button( 'Edit', 'small', 'edit', false ); ?>
                            </form>
                        </td>
					<?php endif; ?>

					<?php if ( isset( $_POST['edit_section'] ) ): ?>
                        <td colspan="2">
                            <form action="options.php" method="post">
                                <input type="text" name="new_title" value="<?= $section['section_title'] ?>"/>
                                <input type="hidden" name="old_title" value="<?= $section['section_title'] ?>">
                                <input type="hidden" name="edit_section" value="<?= $section['section_title'] ?>">
								<?php settings_fields( 'wpcui' ); ?>
								<?php submit_button( 'Save Changes', 'small', 'edit', false ); ?>
                            </form>
                        </td>
					<?php endif; ?>
                    </td>
                </tr>

				<?php
				$sectionControls = array_filter( $controls, function ( $control ) use ( $key ) {
					return $control["section"] == $key;
				} );
				?>

				<?php if ( count( $sectionControls ) == 0 ): ?>
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
                                    <th class="manage-column">ID</th>
                                    <th class="manage-column">Label</th>
                                    <th class="manage-column">Type</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
								<?php foreach ( $sectionControls as $control ): ?>
                                    <tr>
                                        <td><?= $control['control_id'] ?></td>
                                        <td><?= $control['control_label'] ?></td>
                                        <td><?= str_replace( '_', ' ', $control['control_type'] ) ?></td>
                                        <td>
                                            <form action="options.php" method="post" style="margin-right: 5px;">
                                                <input type="hidden" name="remove"
                                                       value="<?= $control['control_id'] ?>">
												<?php settings_fields( 'wpcui-control' ); ?>
												<?php submit_button( 'Delete', 'delete small', 'submit', false, [
													'onclick' => 'return confirm("Are you sure you want to delete this control?")'
												] ); ?>
                                            </form>
                                        </td>
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
