<?php
$local = array(
	'jsModules'=>array('tooltip'=>true),
	'stylesheets'=>array('menu.css'),
	'scripts'=>array('menu.js'),
);
require_once("../inc/application.php");
echo 'here';
$data = $site['utils']->getJson('data.json');

include("RestaurantMenu.class.php");
$menu = new RestaurantMenu($data);

////render
$h->odiv('id="menu-container"');
$h->odiv('id="menu-download"');
$h->a("download.php", "Download");
$h->cdiv(); ////Close download
$menu->renderLinks();
$menu->render();
$h->cdiv();

$template->footer();
?>
