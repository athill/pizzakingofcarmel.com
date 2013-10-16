<?php
include_once('CouponPage.class.php');

class CouponPagePdf extends CouponPage {
	function renderHeader() {
		global $h, $site;
		$fileroot = $site['fileroot'];
		/////////////Header
		$h->tag('img', 'src="'.$fileroot.'/img/pk_logo_black.png"', '');
		$h->otable('width="100%" cellpadding="0" cellspacing="0"');
		////Logo
		$h->otd('valign="top"');
		//$h->tag('img', 'src="'.$fileroot.'/img/pizzakingme.png"', '');
		$h->tag('img', 'src="'.$fileroot.'/img/pk_logo_black.png"', '');
		$h->ctd();
		////pick up or delivery, etc.
		$h->otd('align="center" valign="top" colspan="2" id="specials-calltext"');
		$h->tbr("Pick Up");
		$h->tbr("or");
		$h->tbr("Delivery");
		$h->tbr("CALL");
		$h->ctd();	////Close calltext div
		////Map
		$h->otd('align="center"');
		$h->tag('img', 'src="'.$fileroot.'/img/delivery.png" style="width: 250px;"');
		$h->div("$10.00 Minimum Purchase<br />for Delivery", '');
		$h->ctd(); ////close map 
		$h->corow();
		////address
		$h->td("301 E. Carmel Drive", 'colspan="2" style="font-size: 2em;" '.
			'valign="top"');
		////phone
		$h->td("317.848.7994", 'colspan="2" style="font-size: 4em; font-weight: bold;"');
		$h->ctable(); ////close specials-header div
	
	}
		
	function renderCoupons() {
		global $h;
		$datafile = "data.json";
		$json = file_get_contents($datafile);
		$data = json_decode($json, true);
//		$h->otable('id="specials-coupons"');
		foreach ($data as $i => $item) {
			$item['body'] = str_replace('\"', '"', $item['body']);
			$coupon = new coupon($i, $item['header'], $item['body'], $item['expire']);
//			$h->otd();
			$coupon->display();	
//			$h->ctd();
//			if ($i % 2 == 1 && $i < count($data) - 1) $h->cotr();
		}
//		$h->ctable();
	}

}
?>
