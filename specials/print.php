<?php
/***********************
 * /specials.php
 * @author Andy Hill
 * @description coupon/specials page
 *************************/

$local = array(
	'jsModules'=>array('textfill'=>true),
	'template'=>'Basic',
	'stylesheets'=>array('/css/layout.css'),
);
include("../inc/application.php");
//$h->tnl("text");
include_once("CouponPage.class.php");


$h->script('$(function() {
	////set up
	$(".coupon-body").textfill({ maxFontPixels: 80 });
	$(".coupon-header").textfill({ maxFontPixels: 80 });
	$(".coupon-body").textfill({ maxFontPixels: 80 });
});');


$h->odiv('id="specials"');
$data = $site['utils']->getJson('data.json');
$page = new CouponPage($data);
$page->renderHeader();
$page->renderCoupons();

$h->cdiv(); ////close specials div (whole page)

$template->footer();
?>
