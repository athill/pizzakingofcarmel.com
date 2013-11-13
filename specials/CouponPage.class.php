<?php
include_once('Coupon.class.php');

class CouponPage {

	function __construct($data) {
		$this->data = $data;
	}


	function renderHeader() {
		global $h;
		/////////////Header
		$h->odiv('id="specials-header"');
		////Logo
		$h->img('/img/logo_from_sack.png', "Pizza King", 'id="specials-logo"');
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
		$h->odiv('id="specials-coupons"');
		foreach ($this->data as $i => $item) {
			// $item['body'] = str_replace('\"', '"', $item['body']);
			if (array_key_exists('display', $item) && $item['display'] == 1)  {
				$coupon = new Coupon($i, $item);
				$coupon->display();	
			}
		}
		$h->cdiv();
	}

}
?>
