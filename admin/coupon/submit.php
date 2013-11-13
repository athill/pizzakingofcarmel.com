<?php
$local = array(
	'template'=>'none',
);
$datafile = "data.json";
$pubfile = $site['fileroot']."/specials/data.json";
include("../../inc/application.php");



$mssg='';

//// saving
if (array_key_exists('sequence', $_POST)) {
	$data = array();
	$sequence = explode(',', $_POST['sequence']);
	$h->pa($sequence);
	foreach ($sequence as $item) {
		$id = preg_replace('/cfc-(\d+)/', '$1', $item);
		if (!array_key_exists('admin-delete-'.$id, $_POST)) {
			$display = array_key_exists('admin-display-'.$id, $_POST) ? 1 : 0;
			$data[] = array(
				'header'=>stripcslashes($_POST['admin-header-'.$id]),	
				'body'=>stripcslashes($_POST['admin-body-'.$id]),
				'expire'=>$_POST['admin-expire-'.$id],
				'display'=>$display
			);
		}
	}

	try {
		file_put_contents($datafile, json_encode($data));
		$mssg = 'Coupons updated';
	} catch (Exception $e) {
		print_r($e);
	}
	if (array_key_exists('s_and_p', $_POST)) {
		copy($datafile, $pubfile);
	}
	
}

//// adding
if (array_key_exists('add-header', $_POST)) {
	$data = $site['utils']->getJson($datafile);
	$site['utils']->stripslashes_deep($_POST);
	$data[] = array(
		'header'=>$_POST['add-header'],
		'body'=>$_POST['add-body'],
		'expire'=>$_POST['add-expire'],
		'display'=>array_key_exists('add-display', $_POST) ? '1' : '0',
	);	
	$site['utils']->setJson($datafile, $data);
	$mssg = 'Coupon added';

}

header('location: index.php?mssg='.$mssg);
?>