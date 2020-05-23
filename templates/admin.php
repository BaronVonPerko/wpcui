<?php

use PerkoCustomizerUI\Services\DataService;

/**
 * Template file for the admin backend page.
 */
?>
<div class="wrap">
    <h1>Customizer UI Options</h1>

	<?php settings_errors(); ?>

	<?php do_action( 'wpcui_do_new_section_form' ); ?>

    <hr>

	<?php $settings = DataService::getSettings(); ?>


	<?php if ( count( $settings ) > 0 ): ?>

		<?php foreach ( $settings['sections'] as $key => $section ): ?>
			<?php
			$editSectionId = "edit_section_$key";
			$sectionTitle  = esc_attr( $section['section_title'] )
			?>

            <div class="wpcui-panel" data-wpcui-collapsed="">
                <div class="wpcui-panel-title">
					<?php if ( array_key_exists( $editSectionId, $_POST ) ): ?> <!-- edit section title -->
                        <div class="wpcui-panel-title-buttons">
							<?php do_action( 'wpcui_do_edit_section_form', $sectionTitle ); ?>
                        </div>
					<?php else: ?> <!-- end edit section title, begin collapsible title -->
                        <div class="wpcui-collapsible-title">
							<?php echo file_get_contents( plugin_dir_url( dirname( __FILE__, 1 ) ) . 'assets/chevron.svg' ) ?>
                            <h3><?= $sectionTitle ?></h3>
                        </div> <!-- end of .wpcui-collapsible-title -->
					<?php endif; ?>

					<?php if ( ! array_key_exists( $editSectionId, $_POST ) ): ?>
                        <div class="wpcui-panel-title-buttons">
							<?php do_action( 'wpcui_do_section_action_buttons', [ $editSectionId, $sectionTitle ] ); ?>
                        </div>
					<?php endif; ?>
                </div> <!-- end .wpcui-panel-title -->

                <div class="wpcui-panel-body">
					<?php
					$sectionControls = array_filter( $section['controls'], function ( $control ) use ( $key ) {
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
                                <th class="manage-column">Default</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
							<?php foreach ( $sectionControls as $control ): ?>
								<?php
								$controlId      = esc_attr( $control['control_id'] );
								$controlLabel   = esc_attr( $control['control_label'] );
								$controlType    = str_replace( '_', ' ', esc_attr( $control['control_type'] ) );
								$controlDefault = esc_attr( $control['control_default'] );
								?>
                                <tr>
                                    <td><?= $controlId ?></td>
                                    <td><?= $controlLabel ?></td>
                                    <td><?= $controlType ?></td>
                                    <td><?= $controlDefault ?></td>
                                    <td class="wpcui_control_action_buttons">
										<?php do_action( 'wpcui_do_control_action_buttons', $controlId ); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5">
										<?php do_action( 'wpcui_do_sample_control_code', $control ); ?>
                                    </td>
                                </tr>
							<?php endforeach; ?> <!-- end loop over existing controls -->
                            </tbody>
                        </table>
					<?php endif; ?> <!-- end if no controls show error / otherwise show controls table -->

					<?php do_action( 'wpcui_do_control_form', esc_attr( $key ) ); ?>
                </div> <!-- end .wpcui-panel-body -->
            </div> <!-- end .wpcui-panel -->
		<?php endforeach; ?>

	<?php endif; ?> <!-- end if has sections -->

</div>
