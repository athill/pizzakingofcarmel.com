<?php
////Coupon class
class coupon {
	var $price;
	var $line1;
	var $line2;
	var $line3;
	var $expr;
	
 	function __construct($price, $line1, $line2, $line3, $expr) {
 		$this->price       = $price;
 		$this->line1       = $line1;
		$this->line2       = $line2;
		$this->line3	   = $line3;
		$this->expr	   	   = $expr;
 	}

	function display() {
		global $h;
		global $webroot;
		$h->odiv('class="specials-coupon"');
		///////Top area
		$h->odiv('class="coupon-top"');
		////logo
		$h->img($webroot."/img/logos/pkcar_white_small.png", "Pizza King Logo", 'class="coupon-logo"');
		////$price
		$h->div($this->price, 'class="coupon-price"');
		$h->cdiv();  ////close top div
		////////Text section (3 lines)
		$h->odiv('class="coupon-text"');
		$h->div($this->line1, 'class="coupon-line1"');
		$h->div($this->line2, 'class="coupon-line2"');
		$h->div($this->line3, 'class="coupon-line3"');
		$h->cdiv();  ////close text div
		////disclaimer section
		$h->div("Coupon good only at Pizza King of Carmel. Limit one coupon per order.<br />" .
		"Not valid with other offers. Expires ".$this->expr.".", 'class="coupon-disclaim"');
		$h->cdiv();	////close specials-coupon div
	}

/*
	function display() {
		global $h;
		global $webroot;
		$h->odiv('class="specials-coupon"');
		///////Top area
		$h->odiv('class="coupon-top"');
		////"$"
		$h->div("$", 'class="coupon-dollar"');
		////$price
		$h->div($this->price, 'class="coupon-price"');
		/////top right
		$h->odiv('class="coupon-right"');
		////"off"
		$h->div("OFF", 'class="coupon-off"');
		////logo
		$h->img($webroot."/img/pk_logo_black", "Pizza King Logo", 'class="coupon-logo"');
		$h->cdiv();  ////close right div
		$h->cdiv();  ////close top div
		////////Text section (3 lines)
		$h->odiv('class="coupon-text"');
		$h->div($this->line1, 'class="coupon-line1"');
		$h->div($this->line2, 'class="coupon-line2"');
		$h->div($this->line3, 'class="coupon-line3"');
		$h->cdiv();  ////close text div
		////disclaimer section
		$h->div("Coupon good only at Pizza King of Carmel. Limit one coupon per order.<br />" .
		"Not valid with other offers. Expires ".$this->expr.".", 'class="coupon-disclaim"');
		$h->cdiv();	////close specials-coupon div
	}
*/
}

?>
