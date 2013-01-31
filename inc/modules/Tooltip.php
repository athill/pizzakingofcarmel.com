<?php
include_once("Module.php");

class Tooltip extends Module {
	var $jsfiles = '';
	var $cssfiles = "/css/jquery.tooltip.css";
	var $name = "Tooltip";

	function __construct() {
		//prototype.js,scriptaculous.js,lightbox.js,effects.js
		$incs = explode(",", "jquery.bgiframe.js,jquery.dimension.js,jquery.tooltip.js");
		$js = array();
		function fix($a) { 
			return "/js/jquery/".$a;
		}
		$this->jsfiles = implode(",", array_map(fix, $incs));		
		
		/* 		
	
	for ($i = 0; $i < count($incs); $i++) {
		$includes[] = "/js/jquery/$incs[$i]";
	}
	$includes[] = "";
		*/

		parent::__construct($this->name, $this->jsfiles, $this->cssfiles);
	}
}
