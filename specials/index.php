<?php
/***********************
 * /specials.php
 * @author Andy Hill
 * @description coupon/specials page
 *************************/

$local['jsModules']['textfill'] = true;
include("../inc/application.php");
//$h->tnl("text");
include_once("CouponPage.class.php");

$h->script('
$(function() {
	////set up
	$(".coupon-body").textfill({ maxFontPixels: 80 });
	$(".coupon-header").textfill({ maxFontPixels: 80 });
	$(".coupon-body").textfill({ maxFontPixels: 80 });
});');


if ($site['filename'] != "print.php") {
	$h->odiv('id="specials-printable-link"');
	$h->a("print.php", "Printable Version", 'target="_blank"');
	$h->cdiv();
}


$h->odiv('id="specials"');
$data = $site['utils']->getJson('data.json');
$page = new CouponPage($data);
$page->renderHeader();
$page->renderCoupons();

$h->cdiv(); ////close specials div (whole page)

$template->footer();
?>
