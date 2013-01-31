<?php
session_start();
/*****************************
 * Set a bunch of globals
 ***************************/
$GLOBALS['useView'] = false;

$GLOBALS['webroot'] = "/dev";									//start path for web docs
$GLOBALS['fileroot'] = "/home/content/p/k/c/pkcar/html/dev";			//Start path for files

//initiate the view
if ($GLOBALS['useView']) {
	if (!isset($_GET['view'])) $_GET['view'] = "/";			//Default view
	if (!file_exists($GLOBALS['fileroot'] . $_GET['view'])) $_GET['view'] = "/home/"; 	////Non-existent view, go home
	$GLOBALS['view'] = $_GET['view'];								//View
	$GLOBALS['webscript'] = $GLOBALS['webroot'] . $GLOBALS['view'];	//web path for current view
} else {
	$GLOBALS['view'] = str_replace($webroot, "", $_SERVER['SCRIPT_NAME']);
	$GLOBALS['view'] = str_replace("index.php", "", $GLOBALS['view']);
}



$GLOBALS['webdir'] = preg_replace("/(.*)\/.*\.php$/", "$1", $GLOBALS['webscript']);  	//web path to current directory
$GLOBALS['filescript'] = $GLOBALS['fileroot'] . $GLOBALS['view'];						//file path to current view
$GLOBALS['filedir'] = preg_replace("/(.*)\/.*\.php$/", "$1", $filescript);	//file path to current directory	
if (!preg_match("/\.php$/", $GLOBALS['filescript'])) $GLOBALS['filescript'] .= "index.php";	//Add index.php to dirs
$GLOBALS['filename'] = preg_replace("/.*\/([^\/]+\.php$)/", "$1", $GLOBALS['filescript']);
////Plugins
$GLOBALS['lightbox'] = false;
$GLOBALS['tooltip'] = false;
////Which menu
if (isset($_GET['menuStyle'])) {
	setcookie('menuStyle', $_GET['menuStyle']);
	$GLOBALS['menuStyle'] = $_GET['menuStyle'];
} else if (isset($_COOKIE['menuStyle'])) {
	$GLOBALS['menuStyle'] = $_COOKIE['menuStyle'];
} else {
	$GLOBALS['menuStyle'] = "popup";
}
$GLOBALS['menuStyle'] ? $_GET['menuStyle'] : "popup";
////Build script array from path
$script = preg_replace("/(.*)\/$/", "$1", $GLOBALS['view']);
$script = preg_replace("/^\/(.*)/", "$1", $script);
$GLOBALS['script'] = explode("/", $script);


////default header and footer
$GLOBALS['header'] = '/inc/header.php';
$GLOBALS['footer'] = '/inc/footer.php';

$xmlFile = $fileroot.'/menu.xml';

////parse the XML menu
$xml_parser = xml_parser_create();
if (!($fp = fopen($xmlFile, "r"))) {
   die("could not open XML input");
}
$data = fread($fp, filesize($xmlFile));
fclose($fp);
xml_parse_into_struct($xml_parser, $data, $vals, $index);
xml_parser_free($xml_parser);
$GLOBALS['vals'] = $vals;

include_once($GLOBALS['fileroot'] . "/inc/Html.php.inc");
$h = Html::singleton();
//include_once($GLOBALS['fileroot'] . "/inc/Db.php.inc");
//$db = Db::singleton();

include_once($GLOBALS['fileroot'] . "/inc/Menu.php.inc");
$GLOBALS['sfmenu'] = new Menu($xmlFile);

////Clone globals to local scope
foreach ($GLOBALS as $key=>$val) {
	$$key = $val;
}


include_once($GLOBALS['fileroot'] . "/inc/utils.php");
/////Set title
$path = $sfmenu->buildPathAndSetTitle($sfmenu->xml);
$title = "Pizza King &mdash; Carmel";
if ($GLOBALS['pageTitle'] != "") {
	$title .= " - ".$GLOBALS['pageTitle'];
}

////Override Global settings
if (file_exists($filedir . "/directorySettings.php")) {
	include($filedir . "/directorySettings.php");
}

//Include the header
if ($header != "") {
	include_once($GLOBALS['fileroot'] . $header);
}
?>
