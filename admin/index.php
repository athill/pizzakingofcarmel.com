<?php
include("../inc/application.php");
$lis = array(
	array('href'=>'coupon.php', 'display'=>'Coupons'),
	array('href'=>'star.php', 'display'=>'Star')

);
$h->linkList($lis);

$template->footer();
?>
