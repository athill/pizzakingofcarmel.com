<?php
$local['jsModules']['lightbox'] = true;
$local['jsModules']['jquery-ui'] = true;
$local['scripts'] = array('pictures.js');
$local['stylesheets'] = array('styles.css');
include("../../inc/application.php");
include($site['fileroot'].'/pictures/Pictures.class.php');

$data = $utils->getJson('data.json');

$pics = new Pictures($data, '/admin/pictures/img');
$pics->render(true);



$template->footer();
?>
