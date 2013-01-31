<?php
////page config
$local['stylesheets'] = array('/css/layout.css', 'menu.css');
$local['template'] = "Basic";
//$local['jsModules']['tooltip'] = true;
//$local['scripts'] = array('menu.js');
require_once("../inc/application.php");

include("RestaurantMenu.class.php");
$menu = new RestaurantMenu();
$menu->returnToTop = false;

$h->odiv('id="print-container"');
////render
//$h->odiv('id="menu-container"');
$menu->renderPrint();
//$h->cdiv(); //close menu-container
$h->cdiv(); //close print-container
$template->footer();
?>
