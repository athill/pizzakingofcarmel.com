<?php
$local['jsModules']['tooltip'] = true;
$local['stylesheets'] = array('/menu/menu.css');
$local['scripts'] = array('/menu/menu.js');
require_once("../../inc/application.php");

$data = $utils->getJson('data.json');
include($site['fileroot']."/menu/RestaurantMenu.class.php");
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
