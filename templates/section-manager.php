<div class="wrap">
	<?php use PerkoCustomizerUI\Services\DataService;

	settings_errors(); ?>

    <h1>Section Manager</h1>

	<?php
	$coreSections  = DataService::getCoreCustomizerSections();
	$wpcuiSections = DataService::getSections();
	$sections = array_merge($coreSections, $wpcuiSections);
	usort($sections, function($a, $b) {
	    return $a->priority - $b->priority;
    });
	?>

    <ul>
		<?php foreach($sections as $section): ?>
        <li>
            <?= $section->title; ?>
        </li>
        <?php endforeach; ?>
    </ul>
</div>