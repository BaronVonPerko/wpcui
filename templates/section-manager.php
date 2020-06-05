<?php

use PerkoCustomizerUI\Services\DataService;
use PerkoCustomizerUI\Tables\SectionManagerTable;

$sections = DataService::getAllAvailableSections();

?>

<div class="wrap">
	<?php settings_errors(); ?>

    <h1>Section Manager</h1>

    <p>Use this table to re-order and hide sections.</p>

	<?php
	//$sectionList = new SectionManagerTable( $sections );
	//$sectionList->prepare_items();
	//$sectionList->display();
	?>

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
                    <input type="number" value="<?= $section->priority ?>">
                </td>
                <td>
                    <input type="checkbox" checked>
                </td>
            </tr>
		<?php endforeach; ?>
        </tbody>
    </table>

    <form action="options.php" method="post">
	    <?php settings_fields( 'wpcui' ); ?>
		<?php submit_button() ?>
    </form>
</div>