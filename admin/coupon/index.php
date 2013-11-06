<?php
$local = array(
	'jsModules'=>array(
		'textfill'=>true,
		'jquery-ui'=>true,

	),
	'scripts'=>array('scripts.js')
);
include("../../inc/application.php");
$fileroot = $site['fileroot'];

// print_r($site);



include($site['fileroot']."/specials/Coupon.class.php");

$datafile = "data.json";
$pubfile = $site['fileroot']."/specials/data.json";

// $h->script('');


//$price, $line1, $line2, $line3, $expr
//$coupon = new coupon("012345678", "line1<br />line2<br />line3", "1/1/2020");
//#f02490
//$coupon->display();
$id = "test";
$header = "Filler";
$body = "one line of fun";
$expire = "10/10/2012";

if (array_key_exists('ids', $_POST)) {
	$data = array();
	$ids = explode(',', $_POST['ids']);
	foreach ($ids as $id) {
		if (!array_key_exists('delete-text-'.$id, $_POST)) {
			$display = array_key_exists('display-'.$id, $_POST) ? 1 : 0;
			$data[] = array(
				'header'=>stripcslashes($_POST['header-text-'.$id]),	
				'body'=>stripcslashes($_POST['body-text-'.$id]),
				'expire'=>$_POST['expire-text-'.$id],
				'display'=>$display
			);
		}
	}
	// $h->pa($data);
	$json = json_encode($data);
	$h->tbr($datafile);
	try {
		file_put_contents($datafile, $json);
	} catch (Exception $e) {
		print_r($e);
	}
	
}

//// data
$json = file_get_contents($datafile);
$data = json_decode($json, true);

//// adding
if (array_key_exists('add', $_POST)) {
	$data[] = array(
		'header'=>'filler',	
		'body'=>'a line of text',
		'expire'=>date('m/d/Y'),
		'display'=>0
	);	
}



//// fieldhandler
include($site['fileroot'].'/inc/uft/FieldHandler.class.php');
include('fields.inc.php');
$fh = new FieldHandler($fields, 
	array(
		'data'=>$data,
		'opts'=>array(
			'series'=>true,
		)
	)
);


//// formhandler
include($site['fileroot'].'/inc/uft/FormHandler.class.php');
$formhandler = new FormHandler(
	$fh,
	array(
		'formatts'=>array(
			'id'=>"coupon-admin-form",
			'action'=>''
		)
	)
);

//// render form
$h->oform("");
$h->otable();
$ids = array();
foreach ($data as $i => $item) {
	if ($i > 0) $h->corow();
	$ids[] = $i;
	$h->otd();
//	print_r($item);
	$item['body'] = str_replace('\"', '"', $item['body']);
	couponForm($i, $item['header'], $item['body'], $item['expire'], $item['display']);
	$h->ctd();
	$h->otd();
	$coupon = new coupon($i, $item['header'], $item['body'], $item['expire']);
	$coupon->display();
	$h->ctd();
	$h->corow();
	$h->td('<hr />', 'colspan="2"');
}
$h->ctable();
$h->input('hidden', 'ids', implode(',', $ids));
$h->input("submit", 'add', "Add a Coupon");
$h->input("submit", 's', "Save");
$h->cform();

$template->footer();


////helper
function couponForm($id, $header, $body, $expire, $display) {
	global $h, $fh;
	$h->odiv('class="coupon-form" id="coupon-'.$id.'"');	
	$fh->fieldpair('header');
	$h->tbr("<strong>Header:</strong>");
	$atts = 'class="display-text"';
	if ($display === 1) $atts.= ' checked';
	$h->input("checkbox", "display-".$id, '1', $atts);
	$h->label("display-".$id, ' Display');
	$h->intext("header-text-".$id, $header, 'class="header-text"');	
	$h->input("checkbox", "delete-text-".$id, '1', 'class="delete-text"');
	$h->label("delete-text-".$id, ' Delete');
	$h->br();
	$h->tbr("<strong>Body:</strong>");
	//trim(str_replace("<br />", "\n", $body))
	$h->textarea("body-text-".$id, $body, 'class="body-text"');
	$h->br();
	$h->tbr("<strong>Expire:</strong>");
	$h->intext("expire-text-".$id, $expire, 'class="expire-text"');
	$h->cdiv();
	
}
?>
