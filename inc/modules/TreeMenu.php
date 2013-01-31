<?php
include_once("Module.php");


class TreeMenu extends Module {
	var $jsfiles = '/js/mktree.js';
	var $cssfiles = "/css/mktree.css";
	var $name = "TreeMenu";

	function __construct() {
		parent::__construct($this->name, $this->jsfiles, $this->cssfiles);
	}
}
?>
