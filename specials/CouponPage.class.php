<?php
include_once('Coupon.class.php');

class CouponPage {


	function renderHeader() {
		global $h;
		/////////////Header
		$h->odiv('id="specials-header"');
		////Logo
		$h->img('/img/pk_logo_black.png', "Pizza King", 'id="specials-logo"');
		////pick up or delivery, etc.
		$h->odiv('id="specials-calltext"');
		$h->tbr("Pick Up");
		$h->tbr("or");
		$h->tbr("Delivery");
		$h->tbr("CALL");
		$h->cdiv();	////Close calltext div
		////Map
		$h->odiv('id="specials-map"');
		$h->img('/img/delivery.png', "Pizza King", 'id="specials-delivmap"');
		$h->div("$10.00 Minimum Purchase<br />for Delivery", 'id="specials-minimum"');
		$h->cdiv(); ////close map div
		////address
		$h->div("301 E. Carmel Drive", 'id="specials-addr"');
		////phone
		$h->div("317.848.7994", 'id="specials-phone"');
		$h->cdiv(); ////close specials-header div
	
	}
	
	function renderCoupons() {
		global $h;
		$datafile = "data.json";
		$json = file_get_contents($datafile);
		$data = json_decode($json, true);
		$h->otable('id="specials-coupons"');
		foreach ($data as $i => $item) {
			$item['body'] = str_replace('\"', '"', $item['body']);
			$coupon = new Coupon($i, $item['header'], $item['body'], $item['expire']);
			$h->otd();
			$coupon->display();	
			$h->ctd();
			if ($i % 2 == 1 && $i < count($data) - 1) $h->cotr();
		}
		$h->ctable();
	}

}
?>
