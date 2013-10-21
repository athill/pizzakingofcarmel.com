<?php
include_once($GLOBALS['site']['incroot']."/Html.class.php");
$h = html::singleton();
//echo "included";

class TemplateInstance {


	public $bodyAtts = 'id="default" class="default"';	
	public $stylesheets = array("/css/layout.css", "/css/accessible.css");
	public $scripts = array(//"http://code.jquery.com/jquery-1.7.2.min.js", 
							//"http://code.jquery.com/jquery-migrate-1.1.0.min.js",
							"/js/site.js"
	);
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
		$h->otag('a', 'href="'.$webroot.'" id="header-link"');
		$h->oheader('id="header"');
		$h->img("/img/pizzakingme.png", "", 'id="kingme-left" class="kingme"');
		$h->img("/img/header_logo.png", "Pizza King of Carmel", 'id="header-logo"');
		$h->span("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", 'id="header-spacer"');
		$h->img("/img/magnet_right.png", "We Deliver!", 'id="header-delivery"');
		//$h->cdiv();
		$h->img("/img/pizzakingme.png", "", 'id="kingme-right" class="kingme"');
		$h->img('/img/icons/menu_icon.jpg', 'menu toggle', 'id="menu-toggle"');
		$h->cheader('close #header');
		$h->ctag('a', false, 'close a tag');
		$h->odiv('id="contentwrapper"');
		$h->odiv('id="leftcolumn"');
		//$sfmenu->displayMenu();
		$this->renderGlobalNav();
		$h->cdiv('close #leftcolumn');
		$h->odiv('id="contentcolumn"');

	}

	function renderGlobalNav() {
		global $h;
		//$h->tbr('renderGlobalNav');
		$h->h(3, "Primary Navigation", 'id="primary-navigation" class="hide"');
		$items = $this->base->menu->xmlMenu2array();
		//  $h->pa($items);
		$h->linkList($items, 'class="sf-menu sf-menu sf-vertical" id="global-nav-menu"');
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
		$h->cdiv('close #contentcolumn');	////close content
		


		$h->cdiv('close #contentwrapper'); ////closecontentwrapper

		//$h->cdiv(); ////close main
		//$h->cdiv(); ////close main

		$h->ofooter('id="footer"');
		$h->tnl("&copy; Pizza King of Carmel, ".date('Y')." | ");
		$h->a("/about.php", "About Us");  
		$h->tnl(" | ");
		$h->a("/contact.php", "Contact Us");
		$h->a('/admin', 'Admin', 'id="admin-link"');
		$h->cfooter('close #footer');	////close footer  
		$h->cdiv('close #page');

		$h->chtml();
	}
}

?>
