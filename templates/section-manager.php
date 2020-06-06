<?php

use PerkoCustomizerUI\Services\DataService;
use PerkoCustomizerUI\Tables\SectionManagerTable;

$sections = DataService::getAllAvailableSections();

?>

<div class="wrap">
    <h1>Section Manager</h1>

	<?php settings_errors(); ?>

    <p>Use this table to re-order and hide sections.</p>

	<?php
	//$sectionList = new SectionManagerTable( $sections );
	//$sectionList->prepare_items();
	//$sectionList->display();
	?>

    <form action="options.php" method="post">
		<?php settings_fields( 'wpcui' ); ?>

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
                        <input type="checkbox" checked>
                    </td>
                </tr>
			<?php endforeach; ?>
            </tbody>
        </table>


		<?php submit_button() ?>
    </form>
</div>