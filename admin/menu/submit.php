<?php
session_start();


$local['template'] = 'none';
include("../../inc/application.php");

include($site['fileroot'].'/menu/RestaurantMenu.class.php');

$debug = !$site['isPRD'] && false;



$jsonfile = 'data.json';
$data = $utils->getJson($jsonfile);
$menu = new RestaurantMenu($data);

$newdata = array();

$newdata = $menu->update();

// $h->pa($newdata);

$utils->setJson($jsonfile, $newdata);	



if ($debug) {
	$h->pa($newdata);
} else {
	header('location: index.php');
}
?>