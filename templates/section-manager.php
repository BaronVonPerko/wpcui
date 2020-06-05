<div class="wrap">
	<?php use PerkoCustomizerUI\Services\DataService;

	settings_errors(); ?>

    <h1>Section Manager</h1>

    <p>Use this table to re-order and hide sections.</p>

	<?php
	$coreSections  = DataService::getCoreCustomizerSections();
	$wpcuiSections = DataService::getSections();
	$sections = array_merge($coreSections, $wpcuiSections);
	usort($sections, function($a, $b) {
	    return $a->priority - $b->priority;
    });
	?>

    <table>
        <thead>
        <tr>
            <th class="manage-column">Section</th>
            <th class="manage-column">Priority</th>
            <th class="manage-column">Visibility</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($sections as $section): ?>
            <tr>
                <td><?= $section->title ?></td>
                <td><?= $section->priority ?></td>
                <td></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>