<?php

use PerkoCustomizerUI\Data\DataService;
use PerkoCustomizerUI\Forms\AdminPageFormActions;

$sections = DataService::getAllAvailableSections();
?>

<div class="wrap">
    <h1>Section Manager</h1>

	<?php settings_errors(); ?>

    <p>Use this table to re-order and hide sections.</p>

    <form action="options.php" method="post">
		<?php settings_fields( 'wpcui' ); ?>
        <input type="hidden" name="wpcui_action" value="<?= AdminPageFormActions::SectionManagerSave ?>">

        <table class="wp-list-table widefat fixed striped sections">
            <thead>
            <tr>
                <th class="manage-column">Section</th>
                <th class="manage-column">Priority</th>
                <th class="manage-column">Visibility</th>
            </tr>
            </thead>
            <tbody>
			<?php foreach ( $sections as $section ): ?>
                <tr>
                    <td><?= $section->title ?></td>
                    <td>
                        <input name="section_priority_<?= $section->id ?>"
                               class="wpcui_input_priority"
                               type="number"
                               value="<?= $section->priority ?>">
                    </td>
                    <td>
                        <input name="section_visible_<?= $section->id ?>"
                               type="checkbox" <?= $section->visible ? 'checked' : '' ?>>
                    </td>
                </tr>
			<?php endforeach; ?>
            </tbody>
        </table>


		<?php submit_button() ?>
    </form>
</div>