<?php
include("../inc/application.php");
$lis = array(
	array('href'=>'coupon/', 'display'=>'Coupons'),
	array('href'=>'menu/', 'display'=>'Menu'),
	array('href'=>'star.php', 'display'=>'Star'),
	array('href'=>'pictures/', 'display'=>'Pictures')

);
$h->linkList($lis);

$template->footer();
?>
