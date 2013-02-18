<?php
$local['jsModules']['lightbox'] = true;
$local['jsModules']['jquery-ui'] = true;
$local['scripts'] = array('pictures.js');
$local['stylesheets'] = array('styles.css');
include("../../inc/application.php");
include($site['fileroot'].'/pictures/Pictures.class.php');

$data = $site['utils']->getJson('data.json');

$pics = new Pictures($data);
$pics->render(true);



$template->footer();
?>
