<?php
$local['jsModules']['tooltip'] = true;
$local['stylesheets'] = array('menu.css');
$local['scripts'] = array('menu.js');
require_once("../inc/application.php");

include("RestaurantMenu.class.php");
$menu = new RestaurantMenu();

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
