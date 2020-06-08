<?php

use PerkoCustomizerUI\Services\AdminFormStatus;
use PerkoCustomizerUI\Services\AdminFormStatusService;
use PerkoCustomizerUI\Services\DataService;
use PerkoCustomizerUI\Forms\AdminPageForms;

/**
 * Template file for the admin backend page.
 */
?>
<div class="wrap">
	<?php settings_errors(); ?>

    <h1>Customizer UI Options</h1>

	<?php AdminPageForms::NewSectionForm(); ?>

    <hr>

	<?php $settings = DataService::getSettings(); ?>


	<?php if ( array_key_exists( 'sections', $settings ) ): ?>

		<?php foreach ( $settings['sections'] as $key => $section ): ?>
			<?php
			$editSectionId = "edit_section_$key";
			$sectionTitle  = esc_attr( $section['section_title'] )
			?>

            <!-- show the section panel if we are not editing a control. if we are editing, only show the section the control being edited belongs to -->
			<?php if ( ! AdminFormStatusService::IsEditControl() || AdminFormStatusService::IsEditControlForSection( $key ) ): ?>
                <div class="wpcui-panel" data-wpcui-collapsed="">
                    <div class="wpcui-panel-title">
						<?php if ( AdminFormStatusService::IsEditSectionTitle( $editSectionId ) ): ?> <!-- edit section title -->
                            <div class="wpcui-panel-title-buttons">
								<?php AdminPageForms::EditSectionForm( $sectionTitle ); ?>
                            </div>
						<?php else: ?> <!-- end edit section title, begin collapsible title -->
                            <div class="wpcui-collapsible-title">
								<?php echo file_get_contents( plugin_dir_url( dirname( __FILE__, 1 ) ) . 'assets/chevron.svg' ) ?>
                                <h3><?= $sectionTitle ?></h3>
                            </div> <!-- end of .wpcui-collapsible-title -->
						<?php endif; ?>

                        <!-- Show the edit/delete buttons if not in edit mode -->
						<?php if ( ! AdminFormStatusService::IsEditSectionTitle( $editSectionId ) ): ?>
                            <div class="wpcui-panel-title-buttons">
								<?php if ( ! AdminFormStatusService::IsEditControl() ) {
									AdminPageForms::SectionActionButtons( $editSectionId, $sectionTitle );
								} ?>
                            </div>
						<?php endif; ?>
                    </div> <!-- end .wpcui-panel-title -->

                    <div class="wpcui-panel-body">
						<?php $sectionControls = $section['controls']; ?>

						<?php if ( count( $sectionControls ) == 0 ): ?>
                            <em>There are currently no controls for this section.
                                This section will not appear in the Customizer until <strong>at least</strong> one
                                control has been added to this section. Add a control with the form to the right.
                            </em>
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
									$controlId      = AdminPageForms::GetControlId( $control, $settings );
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
											<?php if ( ! AdminFormStatusService::IsEditControl() ) {
												AdminPageForms::ControlActionButtons( $controlId );
											} ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">
											<?php AdminPageForms::SampleControlCode( $controlId, $controlDefault ); ?>
                                            <hr>
                                        </td>
                                    </tr>
								<?php endforeach; ?> <!-- end loop over existing controls -->
                                </tbody>
                            </table>
						<?php endif; ?> <!-- end if no controls show error / otherwise show controls table -->

						<?php AdminPageForms::ControlForm( esc_attr( $key ) ); ?>
                    </div> <!-- end .wpcui-panel-body -->
                </div> <!-- end .wpcui-panel -->
			<?php endif; ?> <!-- end wpcui-panel -->
		<?php endforeach; ?>

		<?php if ( AdminFormStatusService::IsEditControl() ): ?>
            <em>You are currently editing a customizer control. Your other sections are hidden until you complete the
                edit.</em>
		<?php endif; ?>

	<?php endif; ?> <!-- end if has sections -->

</div>
