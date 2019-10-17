<div class="wrap">
    <h1>WPCUI Options</h1>

	<?php use PerkoCustomizerUI\Services\DataService; ?>

	<?php settings_errors(); ?>

    <form method="post" action="options.php">
		<?php
		settings_fields( 'wpcui' );
		do_settings_sections( 'wpcui' );
		submit_button( 'Create New Section' );
		?>
    </form>

    <hr>

	<?php
	$sections = DataService::getSections();
	$controls = DataService::getControls();
	?>


	<?php if ( count( $sections ) > 0 ): ?>

		<?php foreach ( $sections as $key => $section ): ?>
			<?php $editSectionId = "edit_section_$key"; ?>

            <div class="wpcui-panel" data-wpcui-collapsed="">
                <div class="wpcui-panel-title">
					<?php if ( array_key_exists($editSectionId, $_POST) ): ?> <!-- edit section title -->
                        <div class="wpcui-panel-title-buttons">
                            <form action="options.php" method="post">
                                <input type="hidden" name="edit_section" value="<?= $section['section_title'] ?>">
                                <input type="hidden" name="old_title" value="<?= $section['section_title'] ?>">
                                <input type="hidden" name="edit_section" value="<?= $section['section_title'] ?>">
                                <input type="text" name="new_title" value="<?= $section['section_title'] ?>"/>
								<?php settings_fields( 'wpcui' ); ?>
								<?php submit_button( 'Save Changes', 'small', 'edit', false ); ?>
                            </form>
                            <form action="" method="post">
                                <input type="hidden" name="edit_section" value="">
								<?php settings_fields( 'wpcui' ); ?>
								<?php submit_button( 'Cancel', 'small', 'edit', false ); ?>
                            </form>
                        </div>
					<?php else: ?> <!-- end edit section title, begin collapsible title -->
                        <div class="wpcui-collapsible-title">
							<?php echo file_get_contents( plugin_dir_url( dirname( __FILE__, 1 ) ) . 'inc/Assets/chevron.svg' ) ?>
                            <h3><?= $section['section_title'] ?></h3>
                        </div> <!-- end of .wpcui-collapsible-title -->
					<?php endif; ?>

					<?php if ( ! array_key_exists($editSectionId, $_POST) ): ?>
                        <div class="wpcui-panel-title-buttons">
                            <form action="" method="post">
                                <input type="hidden" name="<?= $editSectionId ?>"
                                       value="<?= $section['section_title'] ?>">
								<?php settings_fields( 'wpcui' ); ?>
								<?php submit_button( 'Edit', 'small', 'edit', false ); ?>
                            </form>

                            <form action="options.php" method="post" style="margin-right: 5px;">
                                <input type="hidden" name="remove" value="<?= $section['section_title'] ?>">
								<?php settings_fields( 'wpcui' ); ?>
								<?php submit_button( 'Delete', 'delete small', 'submit', false, [
									'onclick' => 'return confirm("Are you sure you want to delete this section?")'
								] ); ?>
                            </form>
                        </div>
					<?php endif; ?>
                </div> <!-- end .wpcui-panel-title -->

                <div class="wpcui-panel-body">
					<?php
					$sectionControls = array_filter( $controls, function ( $control ) use ( $key ) {
						return $control["section"] == $key;
					} );
					?>

					<?php if ( count( $sectionControls ) == 0 ): ?>
                        <em>There are currently no controls for this section.</em>
					<?php else: ?>
                        <table class="wpcui-control-table">
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
							<?php endforeach; ?> <!-- end loop over existing controls -->
                            </tbody>
                        </table>
					<?php endif; ?> <!-- end if no controls show error / otherwise show controls table -->

                    <form method="post" action="options.php" class="wpcui-control-form">
                        <input type="hidden" name="section" value="<?= $key ?>">
						<?php
						settings_fields( 'wpcui-control' );
						do_settings_sections( 'wpcui-control' );
						submit_button( 'Create New Control' );
						?>
                    </form>
                </div> <!-- end .wpcui-panel-body -->
            </div> <!-- end .wpcui-panel -->
		<?php endforeach; ?>

	<?php endif; ?> <!-- end if has sections -->

</div>
