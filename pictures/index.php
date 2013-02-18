<?php
$local['jsModules']['lightbox'] = true;
include("../inc/application.php");
include('Pictures.class.php');

$data = $site['utils']->getJson('data.json');

$pics = new Pictures($data);
$pics->render();

$template->footer();
?>
