<?php
date_default_timezone_set('America/New_York');
//// autoloader
require_once('autoload.php');

////useless here if any vars are set. first thing on each page (for sessions)
//session_start();

////Discover webroot and fileroot
$webroot = "";
$basefileroot = "/home/content/p/k/c/pkcar/html";
$host = $_SERVER['HTTP_HOST'];
$self = $_SERVER['PHP_SELF'];
////Local
if ($host == 'localhost' || !array_key_exists('HTTP_HOST', $_SERVER)) {
	$webroot = '/pkcar';
	$basefileroot = '/var/www/html';
}

if ($host == 'pkcar.app') {
	$basefileroot = '/home/vagrant/Code/sites/pkcar';
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

//// Set up site

$site = array(
	"webroot" => $webroot,
	"fileroot" => $basefileroot.$webroot,
	'filename' => basename($self),
	'filedir' => dirname($_SERVER['SCRIPT_FILENAME']),
	"isTST" => $webroot != "",
	"view" => $self,
	"siteName" 	=> "Pizza King of Carmel",
	"leftSideBar" => array('type'=>"none", 'args'=>array()),
	"rightSideBar" => "none",
	"template" => "default",
	"scripts" => array(),
	"stylesheets" => array(),
	'jsModules' => array(
		'popup'=>true
	),
	"useImageHeader" => false,
	"cas"=>false,
	'meta'=>array(
		  'description' => "Pizza KIng of Carmel",
		  'keywords' => "Pizza King,Pizza,King,Carmel,Indiana,Mexican Food",
		  'author' => "Andy Hill",
		  'copyright' => date('Y'). ', Pizza KIng of Carmel',
		  'icon'=>'',
		  'compatible'=>'IE=edge,chrome=1',
		  'viewport'=>'width=device-width',
		  'charset'=>'uft-8'
	)	
);
////Mobile?
require_once('IsMobile.class.php');
$device = new IsMobile();
$site['isMobile'] = $device->isMobile;
$site['isTablet'] = $device->isTablet;

////derived/calculated values
$site['pageTitle']  = $site['siteName'];
$site['isPRD'] = !$site['isTST'];
$site['incroot'] = $site['fileroot'] . "/inc";
//// set $site['path']
$tmp = $_SERVER['PHP_SELF'];
if ($webroot != "") {
	$tmp = str_replace($site['webroot']."/", "", $_SERVER['PHP_SELF']);
}
$tmp = preg_replace("/index.php$/", "", $tmp);
$site['path'] = $tmp;
if (strpos($site['path'], "/") !== 0) {
	$site['path'] = "/".$site['path'];
}
// if ($_SERVER['REMOTE_ADDR'] == '24.1.115.39') echo 'path?!?' . $site['path'].'<br />';	
$site["script"] = explode("/", $tmp);
if (count($site["script"]) > 0 && $site["script"][0] == "") {
	array_shift($site["script"]);
}

////Global objects

$site['h'] = Html::singleton();
$h = $site['h'];
$site['utils'] = new Utils();
$site['logger'] = new Logger();
$site['mailer'] = new Mailer();

////Menu
$xmlfile = $site['fileroot'].'/menu.xml';
if (preg_match('/^\/admin/', $site['path'])) {
	$xmlfile = $site['fileroot'].'/admin/menu.xml';
}
$site['menu'] = new Menu($xmlfile, $site['script']);
//// FIX: $menu should not be global
$menu = $site['menu'];
//$retval = $site['menu']->buildPathAndSetTitle(array('script'=>$site['script']));
$rv = $site['menu']->parseData();
// $h->pa($rv);
$site['breadcrumbs'] = $rv['breadcrumbs'];
$site['pageTitle'] = $rv['pageTitle'];


////Directory Settings -- override global settings for directory
$dirSettings = $site['filedir'].'/directorySettings.php';
if (file_exists($dirSettings)) {
	require_once($dirSettings);
}
if (isset($directory['jsModules'])) $directory['jsModules'] = array_merge($site['jsModules'], $directory['jsModules']) or die("???");
if (isset($directory)) $site = array_merge($site, $directory) or die("???");
////Local Settings override global and directory
if (isset($local['jsModules'])) {
	$local['jsModules'] = array_merge($site['jsModules'], $local['jsModules']) or die("^^^!!");
}
if (isset($local)) $site = array_merge($site, $local) or die("^^^");


////Error handler
////TODO: Move up to global objects?
/*include_once($site['incroot']."/Error.class.php");
$error = new Error();*/
$current_error_reporting = error_reporting();
$old_error_reporting = error_reporting(E_ALL ^ E_NOTICE);

////Template
////TODO: Move instantiation up to global objects? um, no -- needs Menu and Template
include_once($site['incroot']."/site/Template.class.php");
// echo $site['template'];
$template = new Template($site['menu'], $site["template"]);
////TODO: Move head() and heading() to template.start() ?
$template->head();
$template->heading();
?>