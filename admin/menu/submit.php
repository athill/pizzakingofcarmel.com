<?php
//session_start();


$local['template'] = 'none';
include("../../inc/application.php");

include($site['fileroot'].'/menu/RestaurantMenu.class.php');

$debug = !$site['isPRD'] && false;



$jsonfile = 'data.json';
$data = $utils->getJson($jsonfile);
$menu = new RestaurantMenu($data);

$newdata = array();
if (array_key_exists('menu-publish', $_POST)) {
	$pub_file = $site['fileroot'].'/menu/data.json';
	$menu->publish($pub_file);
} else {
	$newdata = $menu->update();
	$utils->setJson($jsonfile, $newdata);	
}


if ($debug) {
	$h->pa($newdata);
} else {
	header('location: index.php');
}
?>