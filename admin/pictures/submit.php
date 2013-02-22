<?php
if (!array_key_exists('title', $_POST) && !array_key_exists('sequence', $_POST)) {
	header('location: index.php');
}

$local['template'] = 'none';
include("../../inc/application.php");
include($site['fileroot'].'/pictures/Pictures.class.php');
$jsonfile = 'data.json';
$data = $utils->getJson($jsonfile);
$pics = new Pictures($data, '/admin/pictures/img');



$newdata = (array_key_exists('title', $_POST)) ? $pics->add() : $pics->update();

$h->pa($newdata);


// $utils->setJson($jsonfile, $newdata);
// chmod($jsonfile, '0664');


$template->footer();
?>