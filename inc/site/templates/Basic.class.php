<?php
include_once($GLOBALS['incroot']."/Html.class.php");
$h = html::singleton();
//echo "included";

class TemplateInstance {


	public $bodyAtts = 'id="default" class="default"';	
	public $stylesheets = array('/css/accessible.css');
	public $scripts = array('/js/jquery.js');
	private $base;
	
	public function __construct($base) {
		$this->base = $base;	
		$GLOBALS['jsModules']['popup'] = false;
	}
	
	public function heading() {
	  global $h, $pageTitle;
	}

	
	public function footer() {
		global $h;
		$h->chtml();
	}
}

?>
