<?php
////page config
$local['stylesheets'] = array('/css/layout.css', 'menu.css');
$local['template'] = "Basic";
//$local['jsModules']['tooltip'] = true;
//$local['scripts'] = array('menu.js');
require_once("../inc/application.php");

$h->div('Temporarily out of service. Please check back soon!', 'class="alert"');

// include("RestaurantMenu.class.php");
// $menu = new RestaurantMenu();
// $menu->returnToTop = false;

// $h->odiv('id="print-container"');
// ////render
// $menu->renderPrint();

// $h->cdiv(); //close print-container
$template->footer();
?>
