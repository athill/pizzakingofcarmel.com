<?php
////Coupon class
class coupon {
	var $header;
	var $body;
	var $expr;
	private $id;
	
 	function __construct($id, $header, $body, $expr) {
 		$this->id		   	= $id;
 		$this->header       = $header;
 		$this->body 		= $body;
		$this->expr	   	   	= $expr;
 	}

	function display() {
		global $h;
		// global $webroot;
		$h->odiv('class="specials-coupon" id="coupon-'.$this->id.'"');
		///////Top area
		$h->odiv('class="coupon-top"');
		////logo
		$h->img("/img/logos/pkcar_white_small.png", "Pizza King Logo", 'class="coupon-logo"');
		////$header
		$atts = 'class="coupon-header"';
		$h->div('<span>'.$this->header.'</span>', $atts);
		$h->cdiv();  ////close top div
		////////Text section (3 lines)
		$this->body = preg_replace("/\n/", '<br />', $this->body);
		$atts = 'class="coupon-body"';		
		$h->div('<span>'.$this->body.'</span>', $atts);
		////disclaimer section
		$atts = 'class="coupon-expire"';
		$h->startBuffer();
		$h->span($this->expr, $atts);
		$expire = $h->endBuffer();
		$h->div("Coupon good only at Pizza King of Carmel. Limit one coupon per order.<br />" .
		"Not valid with other offers. Expires ".$expire.".", 'class="coupon-disclaim"');
		$h->cdiv();	////close specials-coupon div
	}

	function displayPdf() {
		global $h;
		global $webroot;
		$h->otable('class="specials-coupon" id="coupon-'.$this->id.'"');
		///////Top area
		$h->otd('class="coupon-top"');
		////logo
		$h->img("/img/logos/pkcar_white_small.png", "Pizza King Logo", 'class="coupon-logo"');
		////$header
		$atts = 'class="coupon-header"';
		$h->div('<span>'.$this->header.'</span>', $atts);
		$h->ctd();  ////close top div
		$h->corow();
		////////Text section (3 lines)
		$this->body = preg_replace("/\n/", '<br />', $this->body);
		$atts = 'class="coupon-body"';		
		$h->div('<span>'.$this->body.'</span>', $atts);
		////disclaimer section
		$atts = 'class="coupon-expire"';
		$h->startBuffer();
		$h->span($this->expr, $atts);
		$expire = $h->endBuffer();
		$h->div("Coupon good only at Pizza King of Carmel. Limit one coupon per order.<br />" .
		"Not valid with other offers. Expires ".$expire.".", 'class="coupon-disclaim"');
		$h->ctd();
		$h->ctable();	////close specials-coupon div
	}

}
?>
