<?php
// $local['jsModules']['lightbox'] = true;
$local = array(
	'jsModules'=>array('jquery-ui'=>true),
	'scripts' => array('pictures.js'),
	'stylesheets' => array('styles.css'),
);
include("../../inc/application.php");

include($site['fileroot'].'/pictures/Pictures.class.php');

$data = $site['utils']->getJson('data.json');
$pics = new Pictures($data, '/admin/pictures/img');
$pics->render(true);



$template->footer();
?>
