<?php
////Output header
include_once($GLOBALS['fileroot']."/inc/ModuleFactory.php");
$factory = ModuleFactory::singleton();

////Base includes 
$factory->add("Module", array("Base", "/js/jquery/jquery.js", ""));

////Lightbox
if ($GLOBALS['lightbox']) {
	$factory->add("Lightbox");
}
////Tooltip
if ($GLOBALS['tooltip']) {
	$factory->add("Tooltip");
}
////Menu
if ($GLOBALS['menuStyle'] == "tree") { 	
	$factory->add("TreeMenu");	
} else {
	$factory->add("PopupMenu");
}
////site specific
$factory->add("Module", array("Site", "/js/header.js", "/css/layout.css"));
////Build array
$includes = array_merge($factory->cssfiles, $factory->jsfiles); 

$h->ohtml($title, $includes);
////Begin Display
$h->body();
?>
