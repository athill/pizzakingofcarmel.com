<?php
/**
 * HTML generating interface
 *
 * 
 *
 * @package includes
 * @author andy hill 1 2009
 * @version 1.0
 *
 */

class Html {
	 	
 	/**
	 * Tab Depth
	 *
	 */  
 	var $tabs;
 	
 	/**
	 * buffer
	 *
	 * @var object
	 */  
 	var $buffer;
 	

	/*********************
 	 * output or no
         */
	var $output;

	var $strictIndent;

 	/**
	 * Hold an instance of the class
	 *
	 * @var object
	 */  
	private static $instance;
 	
 	/**
	 * constructor
	 *
	 * create an instance of the Logger class
	 * pass in the persistence type(i.e. database, file, standard out)
	 * have a factory create the persistence object that log events are sent to
	 *
	 * @param string
	 */ 
 	function __construct() {
 		$this->tabs       = 0;
 		$this->buffer      = "";
		$this->output      = true;
		$this->strictIndent = true;
 	}	
	
	
	public static function singleton() {
        if (!isset(self::$instance)) {
            $c = __CLASS__;
            self::$instance = new $c;
        }
        return self::$instance;
    }
    
    
    public function __clone() {
        trigger_error('Clone is not allowed.', E_USER_ERROR);
    }
	
	/******************************************************
	 * Start buffering results of functions rather than outputting
	 ******************************************************/
	 public function startBuffer($buffer="") {
	 	$this->buffer = $buffer;
	 	$this->output = false;
	 }
	 
	/******************************************************
	 * Stop buffering results of funcitons, return buffer
	 * @return	string	buffered HTML
	 ******************************************************/
	 public function endBuffer($output=true) {
		if ($output) {
		 	$this->output = true;
		}
		return $this->buffer;
		
	 }	


	/****************
	 * Output functions
	 ***/
	

	public function  op($str) {
		if ($this->output) print($str);
		else $this->buffer .= $str;
	}

	function opnl($str) {
		$this->op($str . "\n");
	}

	public function tab() {
		$this->op(str_repeat("\t", $this->tabs));
	}
	
	public function top($str) {
		$this->op($this->tab(). $str);
	}

	public function topnl($str) {
		$this->top($str . "\n");
	}

	public function tnl($str) {
		$this->topnl($str);
	}

	public function topbr($str) {
		$this->topnl($str . "<br />");
	}

	public function tbr($str) {
		$this->topbr($str);
	}


	function tag($name, $atts="", $content="", $inline=true, $indent=true) {
		$atts = $this->fixAtts($atts);
		if ($content == "") {
			if ($inline) {
				$this->tnl("<${name}${atts} />");
			} else {
				$this->tnl("<${name}${atts}></$name>");
			}
		} else {
			$this->tnl("<${name}${atts}>");
			$this->tabs++;
			$this->tnl($content);
			$this->tabs--;
			$this->tnl("</$name>");
		}
	}

	function otag($name, $atts="", $indent=false) {
		$atts = $this->fixAtts($atts);
		$this->tnl("<${name}$atts>");
		if ($indent) $this->tabs++;
	}

	function ctag($name, $indent=false) {
		if ($indent) $this->tabs--;
		$this->tnl("</$name>");
		
	}
	////Empty tag (/>)
	function etag($name, $atts="", $optAtts="") {
		$atts = $this->fixAtts($atts);
		$optAtts = $this->fixAtts($optAtts);
		$this->tnl("<${name}${atts}$optAtts />");
	}

	function addAtt($name, $value) {
		return " $name=\"$value\"";
	}
	////Prepends a space before attributes if there isn't one
	public function fixAtts($atts) {
		return (strlen($atts) == 0 or $atts[0] == ' ') ? $atts : " " . $atts;
	}

	/*****
	 * Document Tags
	 ******************/
	public function ohtml($pageTitle, $includes=array()) {
		$this->tnl('<?xml version="1.0" encoding="iso-8859-1"?>');
		$this->tnl('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/'.
			'xhtml1-transitional.dtd">');
		$this->tnl('<html xmlns="http://www.w3.org/1999/xhtml">');
		$this->tnl('<head>');
		if ($this->strictIndent) $this->tabs++;
		$this->tnl("<title>$pageTitle</title>");
		$this->tnl('<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />');
		for ($i = 0; $i < count($includes); $i++) {
//			echo $GLOBALS['fileroot'].$includes[$i]."<br />";
			$path_info = pathinfo($GLOBALS['fileroot'].$includes[$i]);
			$uri = $GLOBALS['webroot'].$includes[$i];
    			switch ($path_info['extension']) {
				case "js";
					$this->scriptfile($uri);
					break;
				case "css";
					$this->tnl('<link rel="stylesheet" type="text/css" href="'.$uri.'" />');
					break;				
			}
		}
	}


	public function metaHq($type, $content) {
		$atts = ' http-equiv="'.$type.'" content="'.$content.'"';
		$this->tag("meta", $atts); 
	}

	public function meta($name, $content, $scheme="") {
		$atts = ' name="'.$name.'" content="'.$content.'"';
		if ($scheme != "") $atts .= ' scheme="'.$scheme.'"';
		$this->tag("meta", $atts); 
	}



	public function body($atts="") {
		$atts = $this->fixAtts($atts);
		if ($this->strictIndent) $this->tabs--;
		$this->tnl('</head>');
		$this->tnl("<body$atts>");
	}

	public function chtml() {
		$this->tnl('</body>');
		$this->tnl("</html>");
	}
	
	/********************
	 * General Tags
	 **********************/
	public function br($count=1) {
		$this->tnl(str_repeat("<br />", $count));
	}

	function span($str, $atts="") {
		$atts = $this->fixAtts($atts);
		$this->tnl("<span $atts>$str</span>");
	}

	public function h($count, $str, $atts="") {
		$atts = $this->fixAtts($atts);
		$this->tnl("<h${count}$atts>$str</h$count>");
	}	
	////Links
	public function a($href, $display="", $atts="") {
		if ($display == "") $display = $href;
		$this->tnl('<a href="'.$href.'"'.$this->fixAtts($atts).'>'.$display.'</a>');
	}
	////within webroot
	public function local($href, $display, $atts="") {
		if (array_key_exists("useView", $GLOBALS) && $GLOBALS['useView']) {
			$this->a($GLOBALS['webroot'] . "/index.php?view=" . $href, $display, $atts);
		} else {
			$this->a($GLOBALS['webroot'] . $href, $display, $atts);
		}
	}
	
	public function email($addr, $display="", $atts="") {
		$addr = $this->strtoentity($addr);
		if ($display == "") $display = $addr;
		$this->a("mailto:".$addr, $display, $atts);
	}
	
	////helper for email
	function strtoentity($input)
	{ 
	    foreach (str_split($input) as $obj) 
	    { 
	        $output .= '&#' . ord($obj) . ';'; 
	    }
	    return $output;
	}

	
	////img
	public function img($src, $alt, $atts="") {
		$atts = $this->fixAtts($atts);
		$this->tnl('<img src="' . $src . '" alt="' . $alt . '"'.$atts.'/>');
	}

	///////Javascript
	public function scriptfile($uri) {
		$this->tnl('<script type="text/javascript" src="'.$uri.'"></script>');
	}


	///////CSS
	public function stylesheet($uri) {
		$this->tnl('<link type="text/css" rel="stylesheet" href="'.$uri.'" />');
	}

	public function script($js) {
		$this->tnl('<script type="text/javascript">');
		//add XHTML comments
		$this->top($js);
		if ($js[count($js)] != "\n") $this->op("\n");
		$this->tnl('</script>');
	}



	////divs
	function odiv($atts="") {
		$atts = $this->fixAtts($atts);
		$this->tnl("<div$atts>");
		if ($this->strictIndent) $this->tabs++;
	}

	function cdiv() {
		if ($this->strictIndent) $this->tabs--;
		$this->tnl("</div>");
		
	}

	function div($content="", $atts="") {
		$atts = $this->fixAtts($atts);
		$this->tnl("<div$atts>$content</div>");
	}	
  
	/********************************
	 * List Functions
	 *****************************/
	function oul($atts="") {
		$atts = $this->fixAtts($atts);
		$this->tnl("<ul$atts>");
		$this->tabs++;
	}

	function cul() {
		$this->tabs--;
		$this->tnl("</ul>");
	}

	function li($content, $atts="") {
		$atts = $this->fixAtts($atts);
		$this->tnl("<li$atts>$content</li>");
	}

	function oli($atts="") {
		$atts = $this->fixAtts($atts);
		$this->tnl("<li$atts>");
	}

	function cli() {
		$this->tnl("</li>");
	}
	
	function listArray($type, $items, $listAtts="", $itemsAtts=array()) {
		//$itemsAtts = $this->fixAtts($atts);
		$this->otag($type,  $listAtts);
		for ($i = 0; $i < count($items); $i++) {
			$atts = (array_key_exists($i, $itemsAtts)) ? 
								$this->fixAtts($itemsAtts[$i]) :
								"";  
			$this->tag("li", $atts, $items[$i]);
		}
		$this->ctag($type);
	}


	/***************************
	 * Table functions
	 *************************/

	public function otable($atts="", $trAtts="",$cols="")  {
		$atts = $this->fixAtts($atts);
		$trAtts = $this->fixAtts($trAtts);
		$this->tnl("<table$atts>");
		if ($cols != "") {
			$cols = explode(",", $cols);
			for ($i = 1; $i < count($cols); $i++) {
				h.tnl('<col width="'.$cols[$i].'" />');				
			} 
		}
		$this->tnl("<tr$trAtts>");
		$this->tabs++;
	}

	public function th($content, $atts="") {
		$atts = $this->fixAtts($atts);
		$this->tnl("<th$atts>$content</th>");
	}

	public function td($content, $atts="") {
		$atts = $this->fixAtts($atts);
		$this->tnl("<td$atts>$content</td>");
	}


	public function otd($atts="") {
		$atts = $this->fixAtts($atts);
		$this->tnl("<td$atts>");
	}

	public function ctd() {
		$this->tnl("</td>");
	}

	public function cotr($atts="") {
		$atts = $this->fixAtts($atts);
		$this->tabs--;
		$this->tnl("</tr>");		
		$this->tnl("<tr$atts>");
		$this->tabs++;
	}

	function ctable() {
		$this->tabs--;
		$this->tnl("</tr>");
		$this->tnl("</table>");
	}

	/*******************
	 * Form functions 
	 *********************/
	function oform($action="",$method="post",$atts="") {
		$this->otag("form", " action=\"$action\" method=\"$method\"".$atts);
	}	 

	function cform() {
		$this->ctag("form");
	}

	function select($name, $options, $selected="", $atts='', $empty=false) {
 		$attributes = $this->addAtt("name", $name);
		$this->otag("select", $attributes.$this->fixAtts($atts));
		$this->tabs++;
		//print_r($options);
		if ($empty) array_unshift($options, "");
		for ($i = 0; $i < count($options); $i++) {
			$value = $options[$i];
			if (preg_match("/\|/", $value)) {
				list($value, $display) = explode("|", $value);
			} else {
				$display = $value;
			}
			$atts = 'value="'.$value.'"';
			if ($value == $selected) $atts .= " selected=\"selected\"";
			$this->tag("option", $atts, $display);
		}
		$this->tabs--;
		$this->ctag("select");
	}
	
	function input($type, $name="", $value="", $atts="") {
		$attributes = $this->addAtt("type", $type);
		if ($name != "") $attributes .= $this->addAtt("name", $name);
		if ($value != "") $attributes .= $this->addAtt("value", $value);
		if (!stripos($atts, 'id=')) {
			$attributes .= $this->addAtt("id", $name);
		}
		$this->etag("input", $attributes, $atts);
	}
	
	function intext($name, $value="", $atts="") {
		$this->input("text", $name, $value, $atts);
	}

	function textarea($name, $content="", $atts="", $cols="50", $rows="2") {
		$atts .= $this->addAtt("rows", $rows);
		$atts .= $this->addAtt("cols", $cols);
		if (!stripos($atts, 'id=')) {
			$atts .= $this->addAtt("id", $name);
		}
		$this->tnl('<textarea '.$atts.'>'.$content.'</textarea>');
//		$this->tag("textarea", $atts, $content, false);
	}

	function dictionaryGrid($defns, $atts="") {
		$this->odiv('class="dictionary-grid"'.$atts);
		for ($i = 0; $i < count($defns); $i++) {
			$defn = $defns[$i]; 
			$this->odiv('class="row"');
			$this->div($defn['left'].":", 'class="row-left"');
			$this->div($defn['right'], 'class="row-right"');
			$this->cdiv();	////close row
		}
		$this->cdiv();
	}

}
?>
