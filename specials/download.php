<?php
/***********************
 * /specials.php
 * @author Andy Hill
 * @description coupon/specials page
 *************************/

$local['jsModules']['textfill'] = true;
$local['template'] = 'Basic';
$local['stylesheets'] = array('/css/layout.css');
////start the buffer
ob_start();
include("../inc/application.php");
////DOMPDF
include($incroot."/dompdf/dompdf_config.inc.php");

//$h->tnl("text");
include_once("CouponPagePdf.class.php");

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
//$h->odiv('id="specials"');

$page = new CouponPagePdf();
//$page->renderHeader();
$page->renderCoupons();

//$h->cdiv(); ////close specials div (whole page)

$template->footer();

////save and clear buffer
$html = ob_get_contents();
ob_end_clean();

////render pdf|html
//renderPdf($html);
echo $html;

////pdf helper
function renderPdf($html) {
	$dompdf = new DOMPDF();
	$dompdf->load_html($html);
	$dompdf->render();
	$dompdf->stream("sample.pdf");
}


?>
