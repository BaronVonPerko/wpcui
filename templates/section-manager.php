<?php

use PerkoCustomizerUI\Services\DataService;
use PerkoCustomizerUI\Tables\SectionManagerTable;

?>

<div class="wrap">
	<?php settings_errors(); ?>

    <h1>Section Manager</h1>

    <p>Use this table to re-order and hide sections.</p>

	<?php
	$sectionList = new SectionManagerTable( DataService::getAllAvailableSections() );
	$sectionList->prepare_items();
	$sectionList->display();
	?>
</div>