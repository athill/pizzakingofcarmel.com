<?php
////////////////////////////
//!!!!!!!!!!MOVED!!!!!!!!!!
header("location: /dev/specials/");

/***********************
 * /specials.php
 * @author Andy Hill
 * @description coupon/specials page
 *************************/

////Settings, header, etc.
include_once("inc/application.php");

$h->odiv('id="specials"');
/////////////Header
$h->odiv('id="specials-header"');
////Logo
$h->img($webroot.'/img/pk_logo_black.png', "Pizza King", 'id="specials-logo"');
////pick up or delivery, etc.
$h->odiv('id="specials-calltext"');
$h->tbr("Pick Up");
$h->tbr("or");
$h->tbr("Delivery");
$h->tbr("CALL");
$h->cdiv();	////Close calltext div
////Map
$h->odiv('id="specials-map"');
$h->img($webroot.'/img/delivery.png', "Pizza King", 'id="specials-delivmap"');
$h->div("$10.00 Minimum Purchase<br />for Delivery", 'id="specials-minimum"');
$h->cdiv(); ////close map div
////address
$h->div("301 E. Carmel Drive", 'id="specials-addr"');
////phone
$h->div("317.848.7994", 'id="specials-phone"');
$h->cdiv(); ////close specials-header div


///////////////Coupons
////build array of coupon objects
$expr = "5/21/2010";
$coupons = array(
	new coupon("$1.00 OFF", 
				"ANY LUNCH ENTREE", 
				"Purchase of $4.00 or More",
				"Mon.-Fri. 11:00am - 2:00pm",
				"5/15/2010"),
				
	new coupon("$3.00 OFF", 
				"MONDAY &amp; TUESDAY SPECIALS", 
				"ANY FOOD PURCHASE",
				"of $15.00 or More",
				$expr)				
);

/*
$2.00 off 16 inch pizza.  Toppings of your choice.  Limit 4 discounts per order.
2)$1.50 off 14 inch pizza.  Toppings of your choice.  Limit 4 discounts per order.
3)First time residential discount.  20% off entire order for first time residential delivery orders.  
4)Monday and Tuesday pick-up special.  $3.00 off 16 inch or $2.00 off 14 inch pizza.
5)Free 2 liter of Pepsi products, or free order of breadsticks with food order of $40.00 or more before tax.  Pick-up, dine-in or delivery.
6)Free fountain drink with Lunchtime Entrée purchase.  Monday thru Friday 11:00 am to 2:00 pm.  Dine-in and Pick-up only.
7)Free kids drinks Monday thru Thursday Dine-in only.
8)Buy on garden salad, get one free.  Dine-in, pick-up or delivery.
*/


////Display them
$h->odiv('id="specials-coupons"');
for ($i = 0; $i < count($coupons); $i++) {
	$coupons[$i]->display();
}
$h->cdiv();

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
		$h->img($webroot."/img/pk_logo_black", "Pizza King Logo", 'class="coupon-logo"');
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
$h->cdiv(); ////close specials div (whole page)
if ($footer != "") {
	include_once($GLOBALS['fileroot'] . $footer);
}
?>
