<?php
// $webroot = '/pkcar';
// header('location: '.$webroot.'/img/menu.pdf');
//exit();

////page config
$local['stylesheets'] = array('/css/layout.css', '/menu/menu.css');
$local['template'] = "Basic";
////start the buffer

////defaults/config/template (render header to buffer)
require_once("../inc/application.php");

$data = $site['utils']->getJson('data.json');
// $h->pa($data);
////set up restaurantMenu
include("RestaurantMenu.class.php");
$menu = new RestaurantMenu($data);
// ob_start();
////render content to buffer
// $h->tag('img', 'src="'.$fileroot.'/img/pizzakingme.png"', '');
$h->h1('Pizza King of Carmel');
$h->odiv('id="menu-container"');
$menu->returnToTop = false;
$menu->render();
$h->cdiv(); ///close pdf container
$template->footer();
////save and clear buffer
// $html = ob_get_contents();
// ob_end_clean();

// ////render pdf|html
// // renderPdf($html);
// echo $html;

////pdf helper
function renderPdf($html) {
	global $site;
	$dompdflocation = $site['incroot']."/dompdf/dompdf_config.inc.php";
	// echo $dompdflocation;
	include($dompdflocation);	
	$dompdf = new DOMPDF();
	$dompdf->load_html($html);
	$dompdf->render();
	$dompdf->stream("sample.pdf");
}

?>
