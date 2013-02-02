<?php
include_once($GLOBALS['incroot']."/html.class.php");
$h = html::singleton();
//echo "included";

class TemplateInstance {


	public $bodyAtts = 'id="default" class="default"';	
	public $stylesheets = array("/css/layout.css", "/css/accessible.css");
	public $scripts = array("/js/jquery.js", "/js/site.js");
	private $base;
	
	public function __construct($base) {
		$this->base = $base;	
	}
	
	public function heading() {
	  global $h, $pageTitle;
		
		////Main container
		$h->odiv('id="page"');
		
		$this->displayHeader();
		////Site structure
		$this->base->openLayout();
	}

	private function displayHeader() {
		global $h, $webroot;
		////header container
		////Begin Display
		//$h->body();
		$h->tag("a", 'name="top" id="top"', '', false);
		////header container
		$h->otag('a', 'href="'.$webroot.'"');
		$h->odiv('id="header"');
		$h->img("/img/pizzakingme.png", "", 'id="kingme-left"');
		$h->img("/img/header_logo.png", "Pizza King of Carmel");
		$h->tnl("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
		$h->img("/img/magnet_right.png", "We Deliver!");
		//$h->cdiv();
		$h->img("/img/pizzakingme.png", "", 'style="float: right;" id="kingme-right"');
		$h->cdiv(); ////Close header	
		$h->ctag('a');
		$h->odiv('id="contentwrapper"');
		$h->odiv('id="contentcolumn"');

	}

	function renderGlobalNav() {
		global $h;
		$h->h(3, "Primary Navigation", 'id="primary-navigation" class="hide"');
//		$array = $this->base->menu->xmlMenu2array($this->xml);
		$h->linkList($this->base->menu->xmlMenu2array(), 'class="sf-menu sf-menu sf-vertical" id="global-nav-menu"');
	}


	function geekOut($content) {
		global $h;
		$h->odiv('id="geek-out"');
		$h->span("&nbsp;Geek Out&nbsp;", 'id="geek-out-button"');
		$h->div($content, 'id="geek-out-content" class="hide"');
		$h->cdiv();
	}
	
	private function displaySearch() {
		global $h, $webroot;				
		$h->oform("http://google.com/search", "get");
		$sitesearch = array("|Web", "andyhill.us".$webroot."|Site");
/*
		foreach ($this->base->menu->xml as $elem) {
			$sitesearch[] = "andyhill.us".$webroot.$elem['href']."|".$elem['display'];
		}
*/
		$h->tnl("Search ");
		$h->select("sitesearch", $sitesearch, "andyhill.us$webroot");
		$h->input("text", "q", "", 'size="10" maxlength="255"');
		$h->tnl("by Google");
		$h->cform();
	}
	
	
	private function displaySideNav() {
		global $h;
		$h->odiv('id="column1"');
		$h->h(3, "Secondary Navigation", 'id="secondary-navigation"');
		$h->odiv('id="nav_vertical" class="subnav"');
		$this->base->leftSideBar();
		$h->cdiv();	////close nav_vertical
		$h->cdiv();	////close column1	
		
	}
	
	public function breadcrumbs() {
	  global $h, $breadcrumbs;
//	  $h->pa($breadcrumbs);
	  $h->odiv('id="breadcrumb"');
	  $this->base->breadcrumbs(array('breadcrumbs'=>$breadcrumbs));
	  $h->cdiv();		
	}
	
	public function footer() {
		global $h;
		$this->base->closeLayout();
		$h->cdiv();	////close content
		$h->cdiv(); ////closecontentwrapper

		$h->odiv('id="leftcolumn"');
		//$sfmenu->displayMenu();
		$this->renderGlobalNav();
		$h->cdiv();


		//$h->cdiv(); ////close main
		//$h->cdiv(); ////close main

		$h->odiv('id="footer"');
		$h->tnl("&copy; Pizza King of Carmel, ".date('Y')." | ");
		$h->a("/about.php", "About Us");  
		$h->tnl(" | ");
		$h->a("/contact.php", "Contact Us");
		$h->cdiv();	////close footer  


		$h->chtml();
	}
}

?>
