<?php
session_start();

if (!array_key_exists('title', $_POST) && !array_key_exists('sequence', $_POST)
		&& !array_key_exists('pics-publish', $_POST)) {
	header('location: index.php');
}

$local['template'] = 'none';
include("../../inc/application.php");
include($site['fileroot'].'/pictures/Pictures.class.php');

$debug = !$site['isPRD'] && false;

$jsonfile = 'data.json';
$data = $utils->getJson($jsonfile);
$pics = new Pictures($data, '/admin/pictures/img');

$newdata = array();
if (array_key_exists('pics-publish', $_POST)) {
	$pics->publish($site['fileroot'].'/pictures/data.json', '/img/test');
} else {
	$newdata = (array_key_exists('title', $_POST)) ? $pics->add() : $pics->update();
	$utils->setJson($jsonfile, $newdata);	
}





if ($debug) {
	$h->pa($newdata);
} else {
	header('location: index.php');
}
?>