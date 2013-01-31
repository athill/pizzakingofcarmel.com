<?php
if ($GLOBALS['path'] == "/") $header = "Pizza King &mdash; Carmel";
else $header = $title;

////////////////
// Includes
////////////////
////////Modules
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

///////////////
////Begin display
////////////////
////Output header
$h->ohtml($title, $includes);
////meta tags
$h->meta("description", "Pizza King of Carmel is proud to have served Hamilton County since 1991.");
$h->meta("keywords", "pizza,pizza king,delivery,free delivery, carmel,indiana,hamilton county,central indiana,indianapolis");


	
$script = <<<EOT
\$(document).ready(function(){
	\$("ul.sf-menu").superfish({
            animation: {height:'show'},   // slide-down effect without fade-in 
            delay:     1200               // 1.2 second delay on mouseout 
        });
    });
EOT;
$h->script($script);
////Begin Display
$h->body();
$h->tag("a", 'name="top" id="top"', '', false);
////header container
$h->otag('a', 'href="'.$webroot.'"');
$h->odiv('id="header"');

$h->img($webroot . "/img/pizzakingme.png", "", 'id="kingme-left"');
//$h->odiv('id="header-center"');
//pk_transparent_168x142.png
//$h->img($webroot . "/img/logo_carmel_transparent.png", "Pizza King of Carmel");
//$h->img($webroot . "/img/pk_transparent_168x142.png", "Pizza King of Carmel");
//$h->img($webroot . "/img/header_logo.png", "Pizza King of Carmel");
//$h->tnl("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
//$h->img($webroot . "/img/magnet_right.png", "We Deliver!");
$h->h(1, "Pizza King of Carmel");
$h->tbr("WE DELIVER!");
$h->tbr("Pizza - Sandwiches - Salads - Mexican Food");
$h->tbr("317-848-7994 - 301 E. Carmel Drive");
//$h->cdiv();
$h->img($webroot . "/img/pizzakingme.png", "", 'style="float: right;" id="kingme-right"');

/*
////Images across the top
$images = array('house.jpg',
				'band.jpg',
				'showwater.jpg', 
				'wfhb.jpg'
);
for ($i = 0; $i < count($images); $i++) {
	$h->img("/images/header/" . $images[$i], "", 'id="headerImg'.$i.'" class="header-img"');
}
*/
////Header title
//$h->div($title, 'class="page-header" id="drop"');
//$h->div($title, 'class="page-header"');

$h->cdiv(); ////Close header
$h->ctag('a');
/*
////Gray bar
$h->odiv('id="top-divider"');
//////Do path
$h->odiv('id="path"');
$menu->displayPath($path);
$h->cdiv();
////Search
$h->odiv('id="search"');
$h->oform("http://google.com/search", "get");
$sitesearch = array("|Web", "andyhill.us".$webroot."|Site");
foreach ($menu->xml as $elem) {
	$sitesearch[] = "andyhill.us".$webroot.$elem['href']."|".$elem['display'];
}
$h->tnl("Search ");
$h->select("sitesearch", $sitesearch, "andyhill.us$webroot");
$h->input("text", "q", "", 'size="10" maxlength="255"');
$h->tnl("by Google");
$h->cform();
$h->cdiv(); ////close search div
$h->cdiv(); ////close topDivider div
*/
////Site structure
//$h->odiv('class="colmask"');
$h->odiv('id="contentwrapper"');
$h->odiv('id="contentcolumn"');

if ($GLOBALS['pageTitle'] != "") {
	$h->h(1, $pageTitle);
}
?>
