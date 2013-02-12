<?php
date_default_timezone_set('America/New_York');
////useless here if any vars are set. first thing on each page (for sessions)
//session_start();
///////////////////
//// server vars
//////////////////
$host = $_SERVER['HTTP_HOST'];
$self = $_SERVER['PHP_SELF'];


//////////////////////
////Set up web and file root
/////////////////////////
$webroot = "";
$basefileroot = "/home/content/p/k/c/pkcar/html";

////Local
if ($host == 'localhost' || !array_key_exists('HTTP_HOST', $_SERVER)) {
	$webroot = '/pkcar';
	$basefileroot = '/var/www/html';
}
$webdir = dirname($self);
$subdir = '';
if (stripos($webdir, $webroot."/new") === 0) {
	$subdir .= "/new";
} else if (stripos($webdir, $webroot."/dev") === 0) {
	$subdir .= "/dev";
} else if (stripos($webdir, $webroot."/tst") === 0) {
	$subdir .= "/tst";	
}
$webroot .= $subdir;
$fileroot =  $basefileroot . $webroot;
$basefileroot;

$settings = array(
	"webroot" => $webroot,
	"fileroot" => $fileroot,
	"isTST" => $webroot != "",
	'dir' => dirname($self),
	'filename' => basename($self),
	"view" => $self,
	"siteName" 	=> "Pizza King of Carmel",
	"leftSideBar" => array('type'=>"none", 'args'=>array()),
	"rightSideBar" => "none",
	"template" => "default",
	"scripts" => array(),
	"stylesheets" => array(),
	"useImageHeader" => false,
	"cas"=>false,
	'menufile' =>'/menu.xml'
);
////Defaults based on other defaults
$settings['pageTitle']  = $settings['siteName'];
$settings['isPRD'] = !$settings['isTST'];
$settings['incroot'] = $settings['fileroot'] . "/inc";



// TODO: autoload objects!!!!!!!!
// http://www.php.net/manual/en/function.spl-autoload-register.php




////Global objects
include_once($settings['incroot'] . "/Html.class.php");

$GLOBALS['site']['webroot'] = $webroot;
$settings['h'] = html::singleton();
$h = $settings['h'];
include_once($settings['incroot'] . "/Logger.class.php");

// $settings['logger'] = new Logger();
//include_once($settings['incroot'] . "/ADS.class.php");
//$settings['ads'] = new ADS();
// include_once($settings['incroot'] . "/Mailer.class.php");
// $settings['mailer'] = new Mailer();

////Menu
include_once($settings['incroot']."/Menu.class.php");
$xmlfile = $settings['fileroot'].$settings['menufile'];
if (stripos($self, '/admin/') > -1) {
	$xmlfile = $settings['fileroot'].'/admin/menu.xml';
}
$menu = new Menu($xmlfile);
$retval = $menu->buildPathAndSetTitle();
$settings['breadcrumbs'] = $retval['breadcrumbs'];
$settings['pageTitle'] = $retval['pagetitle'];

//// js/css packages
$settings['jsModules'] = array();
$modules = array(
	"tooltip", "treeTable", "highcharts", "popup", "galleria", "treemenu",
	"jquery-ui", "textfill", 'lightbox'
);
foreach ($modules as $module) {
	if (!array_key_exists($module, $settings['jsModules'])) $settings['jsModules'][$module] = false;
}
$settings['jsModules']['popup'] = true;


////Globalize/localize vars
// foreach ($settings as $key => $value) {
// 	$GLOBALS[$key] = $value;
// 	$$key = $value;
// }

$site = $settings;

////Directory Settings -- override global settings for directory
$dirSettings = $settings['dir'].'/directorySettings.php';
//print_r($GLOBALS);
if (file_exists($dirSettings)) {
echo $settings['dir'];
	require_once($dirSettings);
}


print_r($directory);
if (isset($directory)) $GLOBALS['site'] = array_merge($GLOBALS['site'], $directory) or die("???");
////Local Settings override global and directory
if (isset($local))$GLOBALS['site'] = array_merge($GLOBALS['site'], $local) or die("^^^");

if (isset($directory['jsModules'])) $GLOBALS['site']['jsModules'] = array_merge($settings['jsModules'], $directory['jsModules']) or die("???");
////Local Settings override global and directory
if (isset($local['jsModules'])) {

	$GLOBALS['site']['jsModules'] = array_merge($settings['jsModules'], $local['jsModules']) or die("^^^");
}

//echo '<pre>';
//print_r($GLOBALS['jsModules']);
//echo '</pre>';

//print_r($GLOBALS['stylesheets']);

//echo 'TEMPLATE: '.$GLOBALS["template"];

////Error handler
////TODO: Move up to global objects?
include_once($site['incroot']."/Error.class.php");
$error = new Error($fileroot.'/logs/error.log.txt');

////Template
////TODO: Move instantiation up to global objects? um, no -- needs Menu and Template
include_once($site['incroot']."/site/Template.class.php");
$template = new Template($menu, $GLOBALS['site']["template"]);

////TODO: Move head() and heading() to template.start() ?
$template->head();
$template->heading();

?>
