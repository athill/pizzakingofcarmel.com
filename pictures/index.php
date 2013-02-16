<?php
$local['jsModules']['lightbox'] = true;
include("../inc/application.php");
include('Pictures.class.php');

$data = $site['utils']->getJson('data.js');

$pics = new Pictures($data);
$pics->render();

$template->footer();
?>
