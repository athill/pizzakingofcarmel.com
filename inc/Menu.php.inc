<?php
/**
 * XML menu interface
 *
 * 
 *
 * @package includes
 * @author andy hill 1 2009
 * @version 1.0
 *
 */

class Menu {
	 	
 	/**
	 * Simple Xml Object
	 *
	 */  
 	var $xml;
 	
 	
 	/**
	 * constructor
	 *
	 * create an instance of the Menu class
	 * pass in the persistence type(i.e. database, file, standard out)
	 * have a factory create the persistence object that log events are sent to
	 *
	 * @param string
	 */ 
 	function __construct($pathToXmlFile) {
		if(!$this->xml=simplexml_load_file($pathToXmlFile)) {
		    trigger_error('Error reading XML file',E_USER_ERROR);
		}		
 	}	

	function buildPathAndSetTitle($xml, $path="", $depth=0, $nodes=array()) {
		global $h;
		foreach ($xml as $elem) {
			$node = preg_replace("/\//", "", $elem['href']);
			if ($node == $GLOBALS['script'][$depth]) {		
				$path .= $elem['href'];
				$type = $elem->getName();
				if ($depth + 1 == count($GLOBALS['script'])) {
					$nodes[] = $elem['display'];
					$GLOBALS['pageTitle'] = $elem['display'];
					return $nodes;
				} else {
					$h->startBuffer();
					$h->local($path, $elem['display'], '');	
					$nodes[] = $h->endBuffer();
					$GLOBALS['pageTitle'] = $elem['display'];
					return $this->buildPathAndSetTitle($elem, $path, ++$depth, $nodes);
				}
				
			}
		}
	}
	function displayPath($nodes) {
		global $h;
		global $webroot;
		$h->top("PATH: ");
		if (!preg_match("/\/home\//", $GLOBALS['view'])) {
			$h->local('/home/', "Home");
			$h->op(" &gt;&gt; ");	
		}
		for ($i = 0; $i < count($nodes); $i++) {
			$h->op($nodes[$i]);
			if ($i < count($nodes) - 1) $h->op(" &gt;&gt; ");
		}
		$h->op("\n");
	}

	function displayMenu() {
		global $h;
		global $view;
		if ($GLOBALS['menuStyle'] == "popup") {
			$h->odiv('class="menu"');
			//$h->local("${view}&menuStyle=tree", "Tree Menu");
			$h->oul('class="sf-menu sf-vertical"');
		} else {
			$h->odiv();
			$h->local("${view}&menuStyle=popup", "Popup Menu");
			$h->oul('class="mktree"');
		}
		$this->generateMenu($this->xml);
		$h->cul();
		$h->cdiv();
	}

	function generateMenu($xml, $path="", $depth=0) {
		global $h;
		foreach ($xml as $elem) {
			$h->startBuffer();
			if ($elem['redirect']) $h->a($elem['redirect'], $elem['display']);
			else $h->local($path.$elem['href'], $elem['display']);
			$link = trim($h->endBuffer());
			$type = $elem->getName();
			////Recur if appropriate (limit popup style depth)
			if ($type == "links" && 
					($GLOBALS['menuStyle'] == "tree" 
					|| $depth < 1 )
					&& count($elem->children()) > 0) {
				$h->oli();
				$h->tnl($link);
				$depth++;
				$h->oul();
				$this->generateMenu($elem, $path.$elem['href'], $depth);
				$depth--;
				$h->cul();
				$h->cli();
			} else {	
				$h->li($link);
			}
		}
	}
}
?>
