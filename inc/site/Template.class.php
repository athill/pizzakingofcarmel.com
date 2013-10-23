<?php
$h = html::singleton();

class Template {
	public $template;
	private $templateText = "default";
	private $home;
	public $menu;
	private $includes = array();
	public $hasSkipNav = true;
	
	
	public function __construct($menu, $templateText="default") {
		global $site;
		$this->templateText = $templateText;
		// echo 'um'.$templateText;
		if ($this->templateText == "none") return;
		include_once($site['incroot']."/site/templates/".$this->templateText.".class.php");
		$this->template = new TemplateInstance($this) or die("???");
		$this->menu = $menu;
	}
	
	public function head() {
	  if ($this->templateText == "none") return;
	  global $h, $site;
	  ////Add scripts/sheets from template
//	  $scripts = explode(",", $this->template->scripts);
//	  $sheets = explode(",", $this->template->stylesheets);
//	  $h->pa($this->includes);
	  
	  
	  ////Add scripts/styles from jsModules
	  include_once($site['incroot']."/JsModule.class.php");
	  $jsMods = new JsModule();
	  foreach ($jsMods->jquery as $script) {
	  	$this->includes[] = $script;
	  }
	  foreach ($site['jsModules'] as $module => $bool) {
		  if ($bool) {
			  	$mod = $jsMods->modules[$module];
		  		$this->includes = array_merge($this->includes, $mod['scripts'], $mod['styles']);
		  }
	  }
	  $this->includes = array_merge($this->includes, $this->template->scripts, $this->template->stylesheets);
 	  ////Add scripts/sheets from $GLOBALS
	  $this->includes = array_merge($this->includes, $site['scripts'], $site['stylesheets']);
	  ////HTML/head
	  $title = $site['siteName'];
	  if ($site['pageTitle'] != "") {
		$title .= ': '. $site['pageTitle'];
	  }
	  $h->ohtml($title, $this->includes, $site['meta']);
	  if (array_key_exists('headerExtra', $site)) {
		$h->tnl($site['headerExtra']);  
	  }
	  $h->body($this->template->bodyAtts);
	  if ($this->hasSkipNav) $this->skipNav();		
	}

	public function openLayout() {
		global $h, $site;
		if (method_exists($this->template, 'openLayout')) {
			$this->template->openLayout();
			return;
		}
		////Site structure
		$h->odiv('id="layout"');
		$class = "column123";
		if ($site['leftSideBar']['type'] != "none" && $site['rightSideBar'] != "none") {
			$class = 'column2';	////left-content-right
			$this->leftSideBar($site['leftSideBar']['type'], $site['leftSideBar']['args']);
		} else if ($site['leftSideBar']['type'] != "none") {
			$class = 'column23';	////left-content
			$this->leftSideBar($site['leftSideBar']['type'], $site['leftSideBar']['args']);
		} else if ($site['rightSideBar'] != "none") {
			$class = 'column12';	////content-right
		}
		$h->odiv('id="content-wrapper" class="'.$class.'"');
		$h->odiv('id="content"');
	}

	function closeLayout() {
		global $h, $site;		
		if (method_exists($this->template, 'closeLayout')) {
			$this->template->closeLayout();
			return;
		}		
		$h->cdiv();	////close content
		$h->cdiv();	//close content-wrapper
		//$h->tbr('rsb: ' . $GLOBALS['rightSideBar']);
		if ($site['rightSideBar'] != "none") {
			$this->rightSideBar();
		}
		$h->cdiv();	//close layout


	}
	
	
	////For accessibility
	public function skipNav() {
	  global $h;
	  ////link array. ids generated by lowercasing and replacing spaces with hyphens
	  $links = array(
	  	array("display" => "Content"),
		array("display" => "Search"),
		array("display" => "Primary Navigation")
	  );
	  if ($site['leftSideBar']['type'] != "none") {
		$links[] = 	array("display" => "Secondary Navigation");
	  }
	  ////generate href ids
	  for ($i = 0; $i < count($links); $i++) {
		$links[$i]['href'] = '#'.strtolower(str_replace(" ", "-", $links[$i]['display']));
	  }
	  ////Render
	  $h->odiv('id="skip" class="hide"');
	  $h->p("Skip to:");
	  $h->linkList($links);
	  $h->cdiv();		

	}
	////Website header
	public function heading() {
		if ($this->templateText == "none") return;		
		$this->template->heading();	
	}
	
	////Left side bar
	public function leftSideBar($type, $args) {
		global $h, $site;
		$h->onav('id="column1"');
		if (method_exists($this->template, 'leftSideBar')) {
			$this->template->leftSideBar();
		} else {
			//$h->pa($leftSideBar);
			switch ($type) {
				case "content":
					$h->tnl($args['content']);
					break;
				case 'menu':
					$path = $site['path'];				
					if (array_key_exists('path', $args)) {
						$path = $args['path'];
					}
					$path = preg_replace('/\/[a-z0-9A-Z\-_]+\.php$/', '/', $path);
					$xml = $this->menu->getNodeFromPath(array('path'=>$path));
					$array = $this->menu->xmlMenu2array(array('xml'=>$xml, 'root'=>$path));
			//		$h->pa($array);
					$h->linkList($array, 'class="tree" id="lsb-menu"');
					break;
				default:
					$h->tnl("Unsupported sidebar type");
			}
		}
		$h->cnav('/#column1'); //close column 1
				
	}

	public function rightSideBar() {
		global $h;
		$h->odiv('id="column3"');
		$h->tnl($site['rightSideBar']);
		$h->cdiv(); //close column 3
	}
	
	public function breadcrumbs($opts=array()) {
	  global $h;
//	  $h->pa($opts);
	  //$h->script('KW_breadcrumbs("UIRR Home","&raquo;",0,1,"index.php",4,5)');		
	  $this->menu->renderBreadcrumbs($opts);
	}
	
	public function footer() {
		if ($this->templateText == "none") return;		
		$this->template->footer();	
	}
	
}
?>
