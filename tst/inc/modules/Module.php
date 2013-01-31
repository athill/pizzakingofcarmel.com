<?php 
//include_once($GLOBALS['fileroot']."/includes/ModuleFactory.php");


class Module {
	var $jsfiles = "";
	var $cssfiles = "";
	var $name = "";

	 function __construct($name, $jsfiles, $cssfiles) {
		$this->name = $name;
		$this->jsfiles = $jsfiles;
		$this->cssfiles = $cssfiles;
 	}	
}
?>
