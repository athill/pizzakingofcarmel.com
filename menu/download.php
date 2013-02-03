<?php
$webroot = '/pkcar';
header('location: '.$webroot.'/img/menu.pdf');
exit();

////page config
$local['stylesheets'] = array('/css/layout.css', 'menu.css');
$local['template'] = "Basic";

////start the buffer
ob_start();
////defaults/config/template (render header to buffer)
require_once("../inc/application.php");
////DOMPDF
include($incroot."/dompdf/dompdf_config.inc.php");
////set up restaurantMenu
include("RestaurantMenuPdf.class.php");
$menu = new RestaurantMenuPdf();

////render content to buffer
$h->tag('img', 'src="'.$fileroot.'/img/pizzakingme.png"', '');
$h->odiv('id="pdf-container"');
$menu->render();
$h->cdiv(); ///close pdf container
$template->footer();

////save and clear buffer
$html = ob_get_contents();
ob_end_clean();

////render pdf|html
renderPdf($html);
//echo $html;

////pdf helper
function renderPdf($html) {
	$dompdf = new DOMPDF();
	$dompdf->load_html($html);
	$dompdf->render();
	$dompdf->stream("sample.pdf");
}

?>
