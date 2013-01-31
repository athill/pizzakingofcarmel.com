<?php
include_once("Module.php");


class PopupMenu extends Module {
	var $jsfiles = '/js/jquery/popupMenu/js/hoverIntent.js,/js/jquery/popupMenu/js/superfish.js';
	var $cssfiles = "/js/jquery/popupMenu/css/superfish.css,/js/jquery/popupMenu/css/superfish-vertical.css";
	var $name = "PopupMenu";

	function __construct() {
		parent::__construct($this->name, $this->jsfiles, $this->cssfiles);
	}
}
?>
