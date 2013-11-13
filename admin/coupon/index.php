<?php
$local = array(
	'jsModules'=>array(
		'textfill'=>true,
		'jquery-ui'=>true,
		'uft'=>true

	),
	'scripts'=>array('scripts.js'),
	'stylesheets'=>array('styles.css')
);
include("../../inc/application.php");

if (array_key_exists('mssg', $_GET)) {
	$h->div($_GET['mssg'], 'class="alert"');
}

//// fieldhandler
include('fields.inc.php');
include($site['fileroot'].'/inc/uft/FieldHandler.class.php');
include($site['fileroot'].'/inc/uft/UftGrid.class.php');
include($site['fileroot']."/specials/Coupon.class.php");


$datafile = "data.json";

//// data
$data = $site['utils']->getJson($datafile);


//// Add form
$adddata = array(
	'display'=>true,
	'header'=>'Sample Header',
	'body'=>"Sample\nBody\nText",
	'expire'=>date('m/d/Y', strtotime('next month'))
);
$fh = new FieldHandler($fields, 
	array(
		'data'=>$adddata,
		'opts'=>array('prefix'=>'add'),
	)
);
$uft = new UftGrid(
	$fh,
	array(
		'id'=>"coupon-add-form",
	)
);

$uft->oform();
$h->ofieldset('Add a coupon');
couponForm('add', array(
		'display',
		'header',
		'body',
		'expire',
		array(array('fieldtype'=>'submit', 'name'=>'submit', 'value'=>'Add Coupon'))
	)
);
$coupon = new Coupon('add', $adddata);
$coupon->display();
$h->cfieldset();
$uft->cform();




$fh = new FieldHandler($fields, 
	array(
		'data'=>$data,
		'opts'=>array(
			'series'=>true,
			'prefix'=>'admin'
		)
	)
);

//// admin form
$uft = new UftGrid(
	$fh,
	array(
		'id'=>"coupon-admin-form",
	)
);

//// Form layout
$rows = array(
	array('display', 'delete'),
	'header',
	'body',
	'expire'
);

//// render form
$uft->oform("");
// $h->otable();
$ids = array();
$h->ofieldset('Admin Form');
$h->oul('id="coupon-form-container"');
foreach ($data as $i => $item) {
	$ids[] = $i;
	$h->oli('id="cfc-'.$i.'"');
	couponForm($i, $rows);
	$coupon = new Coupon($i, $item);
	$coupon->display();
	$h->cli('/#cfc-'.$i);
}
$h->cul();
$h->hidden('sequence', '');
$h->submit('s', "Save");
$h->cfieldset();
$uft->cform();

$template->footer();


////helper
function couponForm($id, $rows) {
	global $h, $uft;
	$h->odiv('class="coupon-form" id="coupon-'.$id.'"');	
	$uft->rows($rows);
	$h->cdiv('/#coupon-'.$id);	
}
?>