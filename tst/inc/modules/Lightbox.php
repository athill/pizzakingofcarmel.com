<?php
include_once("Module.php");

class Lightbox extends Module {
	var $jsfiles = '/js/jquery/jquery.lightbox.js';
	var $cssfiles = "/css/jquery.lightbox.css";
	var $name = "Lightbox";

	function __construct() {
		/*
		//prototype.js,scriptaculous.js,lightbox.js,effects.js
		$incs = explode(",", "prototype.js,scriptaculous.js,lightbox.js,effects.js");
		$js = array();
		function fix($a) { 
			return "/js/lightbox/".$a;
		}
		$this->jsfiles = implode(",", array_map(fix, $incs));		
		
		 		
		for ($i = 0; $i < count($incs); $i++) {
			$js[] = "/js/lightbox/$incs[$i]";
		}
		*/

		parent::__construct($this->name, $this->jsfiles, $this->cssfiles);
	}
}
