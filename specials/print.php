<?php
/***********************
 * /specials.php
 * @author Andy Hill
 * @description coupon/specials page
 *************************/

$local['jsModules']['textfill'] = true;
$local['template'] = 'Basic';
$local['stylesheets'] = array('/css/layout.css');
include("../inc/application.php");
//$h->tnl("text");
include_once("CouponPage.class.php");

?>
<script type="text/javascript">
$(function() {
	////set up
	$(".coupon-body").textfill({ maxFontPixels: 80 });
	$(".coupon-header").textfill({ maxFontPixels: 80 });
	$(".coupon-body").textfill({ maxFontPixels: 80 });
});
</script>

<?php

$h->odiv('id="specials"');

$page = new CouponPage();
$page->renderHeader();
$page->renderCoupons();

$h->cdiv(); ////close specials div (whole page)

$template->footer();
?>
