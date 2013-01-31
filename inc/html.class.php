<?php
class html {
	private $indent = 0;
	private $inBuffer = false;
	private $buffer = array();
	private $bufferIndex = -1;
	private $indents = array();
	
	//////////////////////////
	/////Singleton stuff
	///////////////////////////
    // Hold an instance of the class
    private static $instance;
    
    // A private constructor; prevents direct creation of object
    private function __construct() {
       // echo 'I am constructed';
    }
    // The singleton method
    public static function singleton() {
        if (!isset(self::$instance)) {
            $c = __CLASS__;
            self::$instance = new $c;
        }
        return self::$instance;
	}
    // Prevent users to clone the instance
    public function __clone() {
        trigger_error('Clone is not allowed.', E_USER_ERROR);
    }
	
	////////////////////////////////
	////Base functions
	///////////////////////////////		
    private function tab() {
		return str_repeat("\t", $this->indent);	
	}
	
	public function output($string) {
		echo $string;	
	}
	
	public function tnl($string) {
		$string = str_replace("\n", "\n".$this->tab(), trim($string));
		$string = $this->tab() . $string . "\n";
		if ($this->inBuffer) {
			$index = count($this->buffer) - 1;
			$this->buffer[$index] .= $string;
		}
		else print($string);
	}
	
	public function tbr($string) {
		$this->tnl($string . '<br />');	
	}
	
	private function fixAtts($atts) {
		return (substr($atts, 0, 1) === " " || $atts === "") ? $atts : " " . $atts;
	}
	
	public function startBuffer() {
		array_push($this->buffer, "");
		array_push($this->indents, $this->indent);
		$this->indent = 0;
		$this->inBuffer = true;
	}
	
	public function endBuffer() {
		$content = array_pop($this->buffer);
		$this->indent = array_pop($this->indents);
		if (count($this->buffer) == 0) $this->inBuffer = false;
		return $content;	
	}
	
	
    public function otag($tag, $atts='', $indent = true) {
    	$this->tnl("<" . $tag . $this->fixAtts($atts) . ">");
		if ($indent) $this->indent++;
	}
	
	public function ctag($tag, $indent=true) {
		if ($indent) $this->indent--;
		$this->tnl("</" . $tag . ">");	
	}
	////Print an array in pre tags
	public function pa($v) {
		$this->otag('pre');
		print_r($v);
		$this->ctag('pre');	
	}
	
	
	
	/********
	 * Genrates an HTML/XML tag
	 * @param tag		string	required		The tag to generate
	 * @param atts		string	default=''		Attributes for the tag
	 * @param oneline	boolean	default=false	Generate opening and closing tags on same line
	 * 											If true and content is empty, generates empty tag
	 * @param indent	boolean	default=true	If multiline tag, indents the contents
	 ********/
	
	public function tag($tag, $atts='', $content='', $oneline=false, $indent=true) {
		if ($content === "" && !$oneline) {
			$this->tnl("<" . $tag . $this->fixAtts($atts) . " />");	
		} else if ($oneline) {
			$this->tnl("<".$tag.$this->fixAtts($atts).">".$content."</".$tag.">");
		} else {
			$this->otag($tag, $atts, $indent);
			$this->tnl($content);
			$this->ctag($tag);
		}
	}
	
	public function rtn($methodName, $args=array()) {
		if ($methodName == "rtn") die("Recursion fail");
		if (!method_exists($this, $methodName)) die("Bad method name");
		if ($methodName == "startBuffer" || $methodName == "endBuffer") die("Bad method start/endBuffer");
		try {
			$this->startBuffer();
			call_user_func_array(array($this, $methodName), $args);
			return trim($this->endBuffer());		
		} catch (Exception $e) {
			die("Unspecified error in rtn");
		}
		
	}
	
	public function ohtml($title, $includes= array(), $additional="") {
		$this->tnl('<!DOCTYPE html>');
		$this->otag("html", '', false);
		$this->otag("head");
		$this->tag("title", '', $title, true);
		$this->tag("meta", 'charset="utf-8"');
		//$this->tag("meta", 'http-equiv="X-UA-Compatible" content="IE=9"');
		//$this->meta("keywords", "about, mission, UIRR, institutional, research, reporting, indiana, university, IU, Indiana University");
		//$this->meta("description", "The Office of University Institutional Research and Reporting (UIRR) completes myriad federal and state compliance reports and produces official university reports on admissions, enrollment retention, graduation rates, degree completions, and financial aid for Indiana University and all its campuses.");
		//$this->tag("link", 'rel="icon" href="http://www.indiana.edu/favicon.ico"');
		//$this->tag("link", 'rel="shortcut icon" href="http://www.indiana.edu/favicon.ico"');
		for ($i = 0; $i < count($includes); $i++) {
			$filenameParts = explode('.', $includes[$i]);
			$ext = end($filenameParts);
			if ($ext === "js") {
				$this->scriptfile($includes[$i]);		
			} else {
				$this->stylesheet($includes[$i]);
			}
		}
	}
	
	public function body($atts='') {
		$this->ctag("head");	
		$this->otag("body", $atts);
	}
	
	public function chtml() {
		$this->ctag("body");
		$this->ctag("html", false);	
	}
		
	public function scriptfile($files) {
		$files = explode(",", $files);
		foreach($files as $file) {
			if (substr($file, 0, 1) === "/") $file = $GLOBALS['webroot'] . $file;
			$this->tag("script", 'type="text/javascript" src="'. $file .'"', '', true);	
		}
	}
	
	public function script($js) {
		$this->otag('script', 'type="text/javascript"');
		$this->tnl("//<![CDATA[");
		$this->tnl($js);
		$this->tnl("//]]>");
		$this->ctag('script');	
	}
	
	public function stylesheet($files) {
		$files = explode(",", $files);
		foreach($files as $file) {
			if (substr($file, 0, 1) === "/") $file = $GLOBALS['webroot'] . $file;
			$this->tag("link", 'rel="stylesheet" href="'.$file.'" type="text/css"');
		}
	}
	
	public function br($count = 1) {
		if ($count > 0) {
			$this->tnl(str_repeat('<br />', $count));	
		}
	}
	
	public function hr($atts="") {
		$this->tag("hr", $atts);
	}
	
	public function meta($name, $content) {
		$this->tag("meta", 'name="'.$name.'" content="'.$content.'"');	
	}
	
	public function span($content, $atts="") {
		$this->tag("span", $atts, $content, true);
	}
	
	public function div($content, $atts="") {
		$this->tag("div", $atts, $content);
	}
	
	public function odiv($atts='') {
		$this->otag("div", $atts);	
	}
	
	public function cdiv() {
		$this->ctag("div");	
	}

	public function p($content, $atts="") {
		$this->op($atts);
		$this->tnl($content);
		$this->cp();
	}

	public function op($atts="") {
		$this->otag('p', $atts);
	}



	public function cp() {
		$this->ctag('p');
	}	
	
	public function pre($content, $atts="", $escapeHtml=true) {
		$this->otag("pre", $atts);
		if ($escapeHtml) {
			$content = str_replace("<", "&lt;", $content);
			$content = str_replace(">", "&gt;", $content);
		}
		print($content);
		$this->ctag("pre");
	}

	////a href
	public function a($href, $display="", $atts="") {
		global $webroot;
		if (substr($href, 0, 1) == "/") $href= $webroot.$href;
		if ($display === "") $display = $href;
		$atts = 'href="' . $href . '"'.$this->fixAtts($atts);
		$this->tag("a", $atts, $display, true);
	}

	////mailto
	public function email($addr, $display="", $atts="") {
	    $escaped = "";
	    foreach (str_split($addr) as $obj) { 
	        $escaped .= '&#' . ord($obj) . ';'; 
	    }		
		if ($display == "" || $display == $addr) $display = $escaped;
		$this->a("mailto:".$escaped, $display, $atts);
	}
	
	
	////name
	public function name($name, $content="", $atts='') {		
		$atts = 'name="'.$name.'" id="'.$name.'"'.$this->fixAtts($atts);
		$this->tag("a", $atts, $content, true);	
	}
	
	////img
	public function img($src, $alt, $atts='') {
		global $webroot;
		if (substr($src, 0, 1) == "/") $src= $webroot.$src;
		$atts = 'src="'.$src.'" alt="'.$alt.'"'.$this->fixAtts($atts); 
		$this->tag("img", $atts);		
	}
	
	////header tags
	public function h($level, $content, $atts="") {
		$this->tag("h".$level, $atts, $content, true);	
	}
	
	//////////////////////////////////
	//////Lists
	/////////////////////////////
      /**
      *  Creates a list of $listType (ul or ol) with list items defined by $listItemArray
      */
  	public function liArray($listType, $listItemArray, $atts="",$liAtts=array()) {
		if (!$listType === "ul" && !$listType == "ol") $listType = "ul";		 
		$this->otag($listType, $atts);
         for ($i = 0; $i < count($listItemArray); $i++) {
			 $liAttr = (array_key_exists($i, $liAtts)) ? $liAtts[$i] : '';
             $this->tag("li", $liAttr, $listItemArray[$i], true);
         }
         $this->ctag($listType);
     }
	 
	 
	 ////Takes an array of link structs and generates an unordered list
	 ////Links take form of href,display, and optional atts
	 public function linkList($links, $ulAtts="") {
		  //$liAtts = array();
		  $this->otag("ul", $ulAtts);
		 //print_r($links);
		 for ($i = 0; $i < count($links); $i++) {
			$atts = "";
			//print_r($links[$i]);
			if (array_key_exists("atts", $links[$i])) $atts = $links[$i]['atts'];
			$this->startBuffer();
			$this->a($links[$i]['href'], $links[$i]['display'], $atts);
			$link = $this->endBuffer();
			$liAtts = (array_key_exists("liAtts", $links[$i])) ? $links[$i]['liAtts'] : '';
			if (array_key_exists("children", $links[$i])) {
				$this->otag("li", $liAtts, false);
				$this->tnl(trim($link));
				$this->linkList($links[$i]['children']);
				$this->ctag("li", false);
			} else {
				$this->tag("li", $liAtts, trim($link), true);
			}
			
			//$links[$i] = trim($this->endBuffer());
		 }
		 //print_r($links);
		 //$this->liArray("ul", $links, $ulAtts, $liAtts);
		 $this->ctag("ul");
	 }	
	 
	 ////////////////////////////////////////
	 /////////Table functions
	 ////////////////////////////////	 
	 /**
	 * Opens a table	
	 * @param	atts	string	default="" additional attributes
	 * @param	rowAtts	string	default="" additional attributes
	 * @param	cols	string	default="" list of column widths which will generate <col width="X" /> tags
	 */	
	 public function otable($atts="",$rowAtts="",$cols="") {
		 $this->otag("table", $atts);
		 if ($cols != "") {
			$cols = explode(",", $cols);
			foreach($cols as $col) {
				$this->tag("col", 'width="'.$col.'"');
			}
		 }
		 $this->otag("tbody");
		 $this->otag("tr", $rowAtts);
	 }
	 
	 
	/**
	 * Closes a table
	 */
	 public function ctable() {
		$this->ctag("tr");
		$this->ctag("tbody");
		$this->ctag("table"); 
	 }
	 
	 /** 
	  * close/open a table row
	  ****/
	  public function corow($atts="") {
		$this->ctag("tr");
		$this->otag("tr", $atts);
	  }

	  public function cotr($atts="") {
		$this->corow($atts);
	  }
	  
	  public function td($content, $atts="") {
		$this->tag("td", $atts, $content, true);  
	  }
	  
	  public function otd($atts="") {
		$this->otag("td", $atts);  
	  }
	  
	  public function ctd() {
		$this->ctag("td");  
	  }
	  
	  public function th($content, $atts="") {
		$this->tag("th", $atts, $content, true);  
	  }	  
	  
	 
	 ////////////////////////////////////////
	 /////////Form functions
	 ////////////////////////////////
	 public function oform($action, $method="post", $atts="") {
		 //echo $method;
		 $atts = 'action="'.$action.'" method="'.$method.'"'.$this->fixAtts($atts);
		$this->otag("form", $atts); 
	 }
	 
	 public function cform() {
		$this->ctag("form"); 
	 }
	 
	 public function ofieldset($legend="", $atts="", $legendAtts="") {		
		$this->otag('fieldset', $atts); 
		if ($legend != "") $this->tag("legend", $legendAtts, $legend, true);
	 }
	 
	 public function cfieldset() {
		$this->ctag("fieldset"); 
	 }
 
	 public function input($type, $name, $value="", $atts="") {
		//echo 'called';
		$atts = 'type="'.$type.'" name="'.$name.'"'.$this->fixAtts($atts);
		
		if ($value != "") $atts .= ' value="'.$value.'"'; 
		if (!preg_match("/id=\"/", $atts)) $atts .= ' id="'.$name.'"';
		//echo '<input'.$atts.'>';
		
		$this->tag('input', $atts); 
	 }
	 
	 function label($for, $content, $atts="") {
		$atts = 'for="'.$for.'"'.$this->fixAtts($atts);
		$this->tag("label", $atts, $content, true); 
	 }	
	 
	 
	 // AMIT:
	 
	  public function getVal($name, $defaultVal="") {		
		if (array_key_exists($name, $_POST)) return $_POST[$name];
		else if (array_key_exists($name, $_GET)) return $_GET[$name];
	  
		return $defaultVal;
	  }		
	
	  /**
		 * Creates a input type="text"
		 * @param	name	string	required	id and name for input
		 * @param	value	string	default=""	value for input 		
		 * @param	atts	string	default=""	additional attributes
		 */	
	  public function intext($name, $value="", $atts="") {	
		  $atts = $this->fixAtts($atts);		
		  $this->input("text", $name, $value, $atts);
	  }
	  
	  /**
			 * Creates a text area 
			 * @param	name	string	required	name for input
			 * @param	value	string	default=""	value for input 		
			 * @param	atts	string	default=""	additional attributes
			 * @param	rows	string	default="5"
			 * @param	cols	string	default="60"	 	 
			 */	
			public function textarea($name, $value="", $atts="", $rows="5", $cols="60") {		
				if (!strstr($atts, "id=")) $atts .= ' id="'.$name.'"';
				$this->tnl('<textarea name="'.$name.'" rows="'.$rows.'" cols="'.$cols."\"".$atts.">".$value.'</textarea>');
			}	
		
			/**
			 * Creates a select dropdown
			 * @param	name		string	required		name for input
			 * @param	options		array	required		name/value pairs as name|value or name & value will be same
			 * @param	selected	string	default=""		Selected value 		
			 * @param	atts		string	default=""		additional attributes
			 * @param	empty		boolean	default=false	add an empty option to top of select
			 */	
			public function select($name, $options, $selected="", $atts="", $empty=false, $optionClassList="") {
				//print_r($options);
				$i = 1;
				$atts = $this->fixAtts($atts);
				$value="";
				$display="";
				$optionClass="";
				$selectIt="";
				$tempArr = array();
			
				if (!strstr($atts, "id=")) $atts .= ' id="'.$name.'"';	
				//echo "chk2";	
				$this->tnl('<select name="'.$name.'"'.$atts.'>');
	
				//$this->tag('select', $name);
							//echo "chk1";
				$this->tabs++;
				if (!is_array($selected)) $selected = array($selected);
				if ($empty) {$this->tnl('<option value=""></option>'); 	}
				 //echo "chk ";
				for ($i = 0; $i < count($options); $i++) { //print_r($options[$i]);
					if (strstr($options[$i], "|")) {
						if ($options[$i] == "|") {
							$value = "";
							$display = "";
						} else {
							if (substr($options[$i], 0, 1) == "|") {
								$value = "";
								$tempArr = explode("|", $options[$i]);
								$display = $tempArr[1];					// confirm 
							} else if (substr($options[$i], -1) == "|") {
								$tempArr = explode("|", $options[$i]);
								$value = $tempArr[0];
								$display = "";
							} else {
								$tempArr = explode("|", $options[$i]);
								$value = $tempArr[0];
								$display = $tempArr[1];
								//echo "<br>Value Display".$value." ".$display;
							}
						}
					} else {
						$value = $options[$i];
						$display = $value;
					}
					if ($optionClassList != "") {
						if ($i <= count($optionClassList)) {
							$optionClass=' class="'.$optionClassList[$i].'"';			 
						} else {
							$optionClass="";
						}
					}
					
					if (in_array($value, $selected)) {

						$selectIt = ' selected="selected"';
					} else {
						$selectIt = "";
					}	
					//echo "<br>after Value Display".$value." ".$display;	
					$this->tnl('<option value="'.$value."\"".$selectIt.$optionClass.">".$display.'</option>');
				}
				$this->tabs--;
				$this->tnl("</select>");
			}



		////
		public function choicegrid($Arguments, $openContainer = TRUE) {
			
			$i = 0;
			$tempArr = array();
			$Args = array();
			
			
			$defaults = array(
				'type' => "checkbox", 		////radio|checkbox
				'ids' => array(), 			////OPTIONAL custom ids. default is $name_$value
				'selected' => array(), 		////OPTIONAL array of selected values
				'labelfirst' => false, 		////Label to the left of the form field?
				'attsAll' => "", 			////
				'atts' => array(), 
				'labelAttsAll' => "", 
				'labelAtts' => array(), 
				'container' => "none", 		////none|div|table
				'containerAtts' => '', 
				'closeContainer' => true, 
				'numCols' => 0, 
				'selectall' => false, 
				'selectallInitState' => "select", 
				'textfields'=>array(), 
				'labelClass'=>''
			);		

			////required
			$name = $this->reqArgs("name", $Arguments); ////REQUIRED string - form name of checkbox set			
			$vals = $this->reqArgs("vals", $Arguments);	////REQUIRED list - values for checkboxes/radoibuttons
			
			//extend and localize
			$Args = $this->extend($defaults, $Arguments);
			foreach ($Args as $arg => $value) {
				$$arg = $value;	
			}

			////If you're using custom ids, their length should match that of $vals
			if (count($ids) != 0 && count($vals) != count($ids)) {
				echo 'Error in choicegrid. vals and atts not same length';
				exit(1);
			}

			////if there is a select-all link, start it as 'deselect'
			////where does $selectClass come from?
			if (strtolower($selectallInitState) == "deselect") $selectClass = "deselect";
			////
			if ($selectall) $containerAtts = $this->addClass($containerAtts, $selectClass);
			////open the container, iff applicable
			if ($container == "table") $this->otable($containerAtts);
			else if ($container == "div" || ($container == "none" && $selectall)) $this->odiv($containerAtts);
			////iterate through the values

			foreach ($vals as $value) {
				////Handle values of the form $value|$display
				$label = $value;
				if (strpos($value, "|") !== false) {
					list($value, $label) = explode("|", $value);
				}				

				/////deal with ids
				$id = $name."_".$value;
				if (count($ids) > 0) {
					$id = $ids[$i];		
				}
				////label attributes
				$lblAtts = $this->fixAtts($labelAttsAll);
				if (count($labelAtts) > $i) $lblAtts .= $this->fixAtts($labelAtts[$i]); 
				$lblAtts = $this->combineClassAtts($lblAtts);

				////form element atts
				$attrs = $this->fixAtts($attsAll);
				if (in_array($value, $selected) !== false) { 
					$attrs .= $this->fixAtts('checked="checked"');
				} 
				if (count($atts) > $i) $attrs .= $this->fixAtts($atts[$i]);
//				$attrs = $this->combineClassAtts($attrs);
				if (strpos($attrs, 'id=') !== false) {
					$attrs .= $this->fixAtts('id="'.$id.'"');
				}
				////RENDER ITEM
				if ($container == "table") $this->otd();
				if ($labelfirst) {
					$this->label($id, $label, $lblAtts);
				}
				$this->input($type, $name, $value, $attrs);
				if (!$labelfirst) {
					$this->label($id, $label, $lblAtts);
				}
				if (array_key_exists($label, $textfields)) {
					$this->intext($id.'_text', $textfields[$label]);
				}	
				if ($container == "table") $this->ctd();
				if ($numCols > 0 && ($i % $numCols) == 0 && $i < count($vals)) {
					if ($container == "table") $this->corow();
					else $this->br();
				}
			}
			if ($container == "table" && $closeContainer) $this->ctable();
			else if (($container == "div" || ($container == "none" && $selectall)) && $closeContainer) $this->cdiv();	

		}


		
		public function combineClassAtts($atts) {
			$i = 0; 
			$matches = array();
			$re = '/\s?class\s+=\s+"[^"]+"/';
			preg_match($re, $atts, $matches);
			$classes = array();
			$countMatches = count($matches);
			for ($i = 0; $i < $countMatches; $i++) {
				$classes[$i] = preg_replace('/\s?class\s+=\s+"([^"]+)"/', "$1", $matches[$i]);		
			}
			$atts = preg_replace($re, "", $atts);
			$classes = array_unique($classes);
			return (count($classes) == 0) ? $atts : $atts . ' class="'.implode(' ', $classes).'"';
		}
		
		public function reqArgs($arg, $Arguments) {
			if (!array_key_exists($arg, $Arguments)) {
				echo "<script type='text/javascript'>alert('Required argument '".$arg." missing.)</script>";	
			}
			return $Arguments[$arg];
		}
		
		////Overrides struct defaults with options
		public function extend($defaults, $Args) {
			$a = array();
				
			foreach ($defaults as $key => $value) {
				$a[$key] = array_key_exists($key, $Args) ? $Args[$key] : $value;		
			}
			return $a;
		}

		public function addClass($atts, $class) {
			if (strpos($atts, "class=") === false) {
				//$this->tbr("in func". $atts . ' class="'.$class.'"');
				if (strlen($atts) > 0) return $atts . ' class="'.$class.'"';       
				else return $atts . 'class="'.$class.'"';       
			} else {
				$regex = '\s?class="([^"]+)"';
				$classes = preg_replace("/.*".$regex.".*/", "\\1", $atts);
				$pre = preg_replace("/(.*)".$regex.".*/", "\\1", $atts);
				$post = preg_replace("/.*".$regex."(.*)/", "\\2", $atts);
			}
			return $pre . ' class="'.$classes . " ". $class . '"' . $post;
		}

////////////////backwards compatible

////may be a nice idea
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
