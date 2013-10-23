<?php
$local = array(
	'stylesheets'=>array('hours.css'),
);

include("../inc/application.php");

$hours = array(
	array('left'=>"Monday-Thursday", 'right'=>"11:00am to 10:00pm"),
	array('left'=>"Friday", 'right'=>"11:00am to 11:00pm"),
	array('left'=>"Saturday", 'right'=>"4:00pm to 11:00pm"),
	array('left'=>"Sunday", 'right'=>"4:00pm to 10:00pm"),
);

$h->odiv('id="store-hours"');
$h->dictionaryGrid($hours);
$h->cdiv();

$template->footer();
?>
