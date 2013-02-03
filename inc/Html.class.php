<?php
/*
Copyright 2012 andy hill

   Licensed under the Apache License, Version 2.0 (the "License");
   you may not use this file except in compliance with the License.
   You may obtain a copy of the License at

       http://www.apache.org/licenses/LICENSE-2.0

   Unless required by applicable law or agreed to in writing, software
   distributed under the License is distributed on an "AS IS" BASIS,
   WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
   See the License for the specific language governing permissions and
   limitations under the License.

 */
/**
 * HTML generating interface
 *
 * @package includes
 * @author andy hill 1 2009-2012
 * @version 3.0
 *
 */

require_once('Xml.class.php');

class Html extends Xml {

	private static $instance;
 	


 	/**
	 * constructor
	 */ 
 	function __construct() {
		$GLOBALS['site']['webroot'] = (array_key_exists('site', $GLOBALS) && 
				array_key_exists('webroot', $GLOBALS['site'])) ? 
			$GLOBALS['site']['webroot'] :
			''; 		
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

	function __call($name, $args) {
		$emptyTags = explode(',', "area,base,br,col,hr,img,input,keygen,link,meta,param,source,track");
		$nonemptyTags = explode(',', "a,abbr,address,article,aside,audio,b,bdi,bdo,blockquote,body,canvas,caption,cite,code,colgroup," .
			"command,datalist,dd,del,details,dfn,div,dl,dt,em,embed,fieldset,figcaption,figure,footer,form,h1,h2,h3,h4,h5,h6," .
			"head,header,hgroup,html,i,iframe,ins,kbd,label,legend,li,map,mark,menu,meter,nav,noscript,object,ol,optgroup,option," .
			"output,p,pre,progress,q,rp,rt,ruby,s,samp,script,section,select,span,strong,style,sub,summary,sup,table,tbody," .
			"td,textarea,tfoot,th,thead,time,title,tr,u,ul,var,video,wbr");
		$indentTags = explode(',', "datalist,div,dl,fieldset,footer,header,nav,ol,section,select,tr,ul");
		$command = substr($name, 0, 1);
		$tag = substr($name, 1);
		//echo 'command: '. $command . ' tag: ' . $tag . ' in array?'. in_array($tag, $nonemptyTags);
		////empty tag
		if (in_array($name, $emptyTags) && $name != 'col') {
			$atts = count($args) > 0 ? $args[0] : '';
			$this->tag($name, $atts);
		////input tag
		} else if (in_array($name, explode(',', "radio,checkbox,hidden,submit,button,intext,date,color,datetime,"&
				"inemail,range,search,tel,time,url,week"))) {
			$fieldname = $args[0];
			$value = count($args) >= 2 ? $args[1] : '';
			$atts = count($args) >= 3 ? $args[2] : '';
			if ($name == 'date') {
				$atts = $this->addClass($this->fixAtts($atts), "datepicker");
				if (strpos("size=", atts) === false) $atts .= ' size="15"';
			}
			$pos = strpos('in', name);
			if ($pos == 0) $name = str_replace('in', '', $name);
			$this->input($name, $fieldname, $value, $atts);
		////open/close tag
		} else if (in_array($name, $nonemptyTags)) {
			$content = $args[0];
			$atts = count($args) >= 2 ? $args[1] : '';
			$inline = !preg_match('/\n/', $content);
			$this->tag($name, $atts, $content, $inline, false);
		////open tag
		} else if ($command == 'o' && in_array($tag, $nonemptyTags)) {
			$atts = count($args) > 0 ? $args[0] : '';
			$indent = in_array($tag, $indentTags);
			// echo $indent;
			$this->otag($tag, $atts, $indent);
		////close tag
		} else if ($command == 'c' && in_array($tag, $nonemptyTags)) {
			$comment = count($args) > 0 ? $args[0] : '';
			$indent = in_array($tag, $indentTags);
			$this->ctag($tag, $indent, $comment);
		////close/open tag
		} else if (substr($name, 0, 2) == 'co' && in_array(substr($name, 2), $nonemptyTags)) {
			$tag = substr($name, 2);
			$indent = in_array($tag, $indentTags);
			$atts = count($args) > 0 ? $args[0] : '';
			$this->ctag($tag, $indent);
			$this->otag($tag, $atts, $indent);
		} else {
			parent::__call($name, $args);	
		}		
	}

	private function fixLink($link) {
		// print_r($GLOBALS['site']);
		return (substr($link, 0, 1) == "/") ? $GLOBALS['site']['webroot'] . $link : $link;
	}

	/*****
	 * Document Tags
	 ******************/
	public function ohtml($title, $includes= array(), $additional="") {
		$this->tnl('<!DOCTYPE html>');
		$this->otag("html", 'lang="en"', false);
		$this->otag("head");
		$this->tag("title", '', $title, true);
		$this->tag("meta", 'charset="utf-8"');
		//<meta http-equiv="X-UA-Compatible" content="IE=9" >
		$this->tag("meta", 'http-equiv="X-UA-Compatible" content="IE=9"');
		$this->meta("keywords", "");
		$this->meta("description", "");
		$this->tag("link", 'rel="icon" href=""');
		$this->tag("link", 'rel="shortcut icon" href=""');
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

	////Links
	public function a($href, $display="", $atts="") {
		if ($display == "") $display = $href;
		$this->tnl('<a href="'.$this->fixLink($href).'"'.$this->fixAtts($atts).'>'.$display.'</a>');
	}

	////img
	public function img($src, $alt, $atts="") {
		$atts = $this->fixAtts($atts);
		$this->tnl('<img src="' . $this->fixLink($src) . '" alt="' . $alt . '"'.$atts.'/>');
	}

	///////Javascript
	public function scriptfile($files) {
		//$this->tnl('<script type="text/javascript" src="'.$uri.'"></script>');
	  	if (!is_array($files)) $files = array($files);
		foreach ($files as $file) {
			//if (substr($file, 0, 1) == "/") $file = $GLOBALS['site']['webroot'] . $file;
			//$this->tnl('<link rel="stylesheet" type="text/css" href="'.$sheet.'" />');	
			$this->tag('script', 'src="'.$this->fixLink($file).'"', '', true, false);
		}		
	}

	public function script($js) {
		$this->oscript();
		//add XHTML comments
		$this->tnl(trim($js));
		//if ($js[count($js)] != "\n") $this->wo("\n");
		$this->cscript();
	}	
	/***
	 * Opens a script tag
	 */
	 public function oscript() {
		$this->otag('script', array('type'=>'text/javascript'));
	 	$this->tnl("//<![CDATA[");
	 }

	/***
	 * Closes a script tag
	 */
	 public function cscript() {
	 	$this->tnl("//]]>");
		$this->ctag('script');
	 }

	/***
	 * opens a style tag
	 */	 
	 public function ostyle() {
		$this->otag('style', array('type'=>'text/css'));
	 	$this->tnl("<!--");
	 	
	 }
	/***
	 * Generates style declarations based on an array of {match}->{rules}
	 * TODO: wtf??
	 */	 
	 public function style($styles) {
		$this->ostyle();
		foreach  ($styles as $style) {
			$this->tnl($style);
		}
		$this->cstyle(); 
	 }
	/***
	 * closes a style tag
	 */	 
	 public function cstyle() {
	 	$this->tnl("-->");
		$this->ctag('style');
	 }

	/***
	 * Generates stylesheet link tag(s) 
	 */	 
	  public function stylesheet($sheets) {
	  	if (!is_array($sheets)) $sheets = array($sheets);
		foreach ($sheets as $sheet) {
			if (substr($sheet, 0, 1) == "/") $sheet = $GLOBALS['site']['webroot'] . $sheet;
			$this->tnl('<link rel="stylesheet" type="text/css" href="'.$sheet.'" />');	
		}
	 }	 

	/***
	 * generates a JavaScript alert
	 */	 
	  public function alert($content) {
	 	$this->script('alert("'.$content.'");');
	 }
	 
	/***
	 * Geerates an HTML comment
	 */	 
	  public function comment($content) {
	 	$this->tnl("<!-- ".$content." -->");
	 }

	/**
	 * Creates header tag
	 * @param	level	int		required	header level 1-6
	 * @param	content	string	required	content of header
	 * @param	atts	string	default="" 	additional attributes
	 */
	 public function h($level, $content, $atts='') {
//		tnl('<h#level##atts#>#content#</h#level#>');
		$this->tag('h'.$level, $atts, $content, true);
	}

	/**
	 * Opens a table	
	 * @param	atts	string	default="" additional attributes
	 * @param	rowAtts	string	default="" additional attributes
	 * @param	cols	string	default="" list of column widths which will generate <col width="X" /> tags
	 */	
	public function otable($atts='', $rowAtts='', $cols='') {
		$this->otag('table', $atts);
		if ($cols != "") {
			////TODO WHY WON'T THIS WORK?
			//$cols = explode(',' $cols);
			foreach ($cols as $col) {
				$this->tag('col', array('width'=>$col));
			}
		}
		$this->otag('tbody');
		$this->otag('tr', $rowAtts, true);

	}
	
	public function corow($atts='') {
		$this->ctag('tr', true);
		$this->otag('tr', $atts, true);
	}
	
	/**
	 * Closes a table
	 */
	public function ctable() {
		$this->ctag('tr', true);
		$this->ctag('tbody');
		$this->ctag('table');
	}

	
	/**
	 * Evaluates contents of a table cell
	 */	
	public function evaltd($eval, $atts='') {
		$this->otag('td', $atts);
		eval($eval);
		$this->ctag('td');
	}
	
	public function simpleTable($options=array()) {
		$defaults = array(
			'headers'=>array(),
			'data'=>array(),
			'atts'=>'',
			'caption'=>''
		);
		$options = $this->extend($defaults, $options);
		if (!is_array($options['headers'])) $options['headers'] = explode(',', $options['headers']);
		$this->otag('table', $options['atts']);
		////caption
		if ($options['caption'] != '') {
			$this->tag('caption', '', $options['caption'], true, false);
		}
		////headers
		if (count($options['headers']) > 0) {
			$this->otag('thead');
			$this->otag('tr', '', true);
			foreach ($options['headers'] as $header) {
				$this->tag('th', '', $header, true, false);
			}
			$this->ctag('tr', true);
			$this->ctag('thead');
		}
		////data
		$this->otag('tbody');
		foreach ($options['data'] as $row) {
			$this->otag('tr', '', true);
			foreach ($row as $cell) {
				$this->tag('td', '', $cell, true, false);	
			}
			$this->ctag('tr', true);
		}
		$this->ctag('tbody');
		$this->ctag('table');	
	}	

	/********************************************
	 * List Functions
	 **********************************************/
     /**
      *  Creates a list of $listType (ul or ol) with list items defined by $listItemArray
      */
  	public function liArray($listType, $listItemArray, $atts='', $liAtts='') {
		if (!in_array($listType, array("ul","ol"))) $listType = "ul";
		 $this->otag($listType, $atts, true);
         foreach ($listItemArray as $item) {
             $this->tag("li", $liAtts, $item);
         }
         $this->ctag($listType, true);
     }

	 ////Takes an array of link structs and generates an unordered list
	 ////Links take form of href,display, and optional atts
	 public function linkList($links, $ulAtts="") {
		  //$liAtts = array();
		  $this->otag("ul", $ulAtts, true);
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
		 $this->ctag("ul", true);
	 }	     

     /*************************
      * Deprecated
      ************************/
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

	/*********************************************
	 *  Form functions						 *
	 *********************************************/
	  function formTable($config) {
	  	$defaults = array(
			'atts'=>'',
			'type'=>'checkbox',
			'upper_left_label'=>'&nbsp;',
			'headers'=>array(),
			'subheaders'=>array(),
			'rows'=>array(),
			'sideLabelAtts'=>'class="side-header"',
			'mode'=>'view',
			'useLabelAsValue'=>false
		);  
		$config = $this->extend($defaults, $config);
		$arrays = explode(',', 'headers,subheaders,rows');
		foreach ($arrays as $array) {
			foreach ($config[$array] as $i => $value) {
				if (!is_array($value)) {
					$val = explode('|', $value);
					$config[$array][$i] = array('id'=>$val[0]);
					$config[$array][$i]['label'] = (count($val) >= 2) ? $val[1] : $val[0];
					if (count($val) >= 3) $config[$array][$i]['type'] = $val[2];
				}
			}
		}
		$colspan = '';
		if (count($config['subheaders']) > 0) {
			$colspan = ' colspan="'.count($config['subheaders'])/count($config['headers']).'"';
		}
		$this->otable($config['atts']);
		$this->th($config['upper_left_label']);
		foreach ($config['headers'] as $header) {
			$this->th($header['label'], $colspan);	
		}
		if ($config['type'] == 'radio' && $config['mode'] == 'form') {
			$this->th('Clear');
		}
		if (count($config['subheaders']) > 0) {
			$this->corow();
			$this->th('&nbsp;');
			foreach ($config['subheaders'] as $subheader) {
				$this->th($subheader['label']);
			}
			if ($config['type'] == 'radio' && $config['mode'] == 'form') {
				$this->th('&nbsp;');
			}			
		}
		foreach ($config['rows'] as $row) {
			$atts = ' ';
			$name = '';
			$type = $config['type'];
			$this->corow();
			$headers = count($config['subheaders']) ? $config['subheaders'] : $config['headers'];
			if (array_key_exists('atts', $row)) {
				$atts = $row['atts'];
			}
			////set up colspans
			$labelAtts = (array_key_exists('labelAtts', $row)) ? 
				$labelAtts = $row['labelAtts'] : 
				$config['sideLabelAtts'];
			if (array_key_exists('colspan', $row) && is_array($row['colspan'])) {
				list($start, $end) = explode('-', $row['colspan']['span']);
				$spans = array();
				$spanning = false;
				if ($start == '[label]') {
					$labelAtts .= ' colspan="'. (count($headers) + 1).'"';
					$spans[] = '[label]';
				}				
				foreach ($headers as $header) {
					if ($header['id'] == $start || $start == '[label]') $spanning = true;
					if ($spanning) $spans[] = $header['id'];
					if ($header['id'] == $end) break;
				}
			}
			$this->th($row['label'], $labelAtts);
			foreach ($headers as $header) {
				$thisAtts = $atts;
				$type = (array_key_exists('type', $header)) ? $header['type'] : $config['type'];
				$type = (array_key_exists('type', $row)) ? $row['type'] : $type;	
				$name = $header['id'];
				if (array_key_exists('colspan', $row) && in_array($name, $spans)) {
					if ($name == $spans[0]) {
						$content = (array_key_exists('content', $row['colspan'])) ? 
							$row['colspan']['content'] : 
							'&nbsp;';
						$this->td($content, 'colspan="'.count($spans).'"');
					}
				} else {
					$this->otd();
					if ($type == 'text') {
						$value = '';
						if (array_key_exists('values', $row) && array_key_exists($name, $row['values'])) {
							$value = $row['values'][$name];
						}
						if (array_key_exists('totals', $row) && array_key_exists($name, $row['totals'])) {
							$value = 0;
							//$this->tbr('totals for '.$row['id'].' : '.$row['totals'][$name]);
							$addends = explode(',', $row['totals'][$name]);
							foreach($addends as $addend) {
								
								if (strpos($addend, '_')) {
									list($qid,$hid) = explode('_', $addend);
								} else {
									$qid = $row['id'];
									$hid = $name;	
									$value = 0;
								}
								foreach ($config['rows'] as $r) {
									//$this->tbr('looping: '.$r['id'] . ' '.$hid);
									if ($qid == $r['id'] && array_key_exists('values', $r) 
											&& array_key_exists($hid, $r['values'])) {
										$value += $r['values'][$hid];
										//$this->tbr($hid.': '.$value);
									}
								}
							}
							$thisAtts = $this->combineClassAtts($thisAtts.' class="formtable-totals" data-totals="'.$row['totals'][$name].'"');
							$row['values'][$name] = $value;
							
						}
//						$this->tbr($config['type']);
						if ($config['mode'] == 'view') {
							$this->span($value, $thisAtts.' id="'.$row['id'].'_'.$name.'"');
						} else {
							$this->input($type, $row['id'].'_'.$name, $value, $thisAtts);
						}
					} else {
						$thisAtts = $atts.' id="'.$row['id'].'_'.$name.'"';
						$viewValue = '';
						if (array_key_exists('selected', $row) && in_array($name, $row['selected'])) {
							$thisAtts .= ' checked="checked"';
							$viewValue = 'X';
						}
						$value = ($config['useLabelAsValue']) ? $header['label'] : $row['id'];
						if ($config['mode'] == 'view') {
							$this->span($viewValue, $thisAtts);
						} else {
							$this->input($type, $row['id'].'[]', $value, $thisAtts);
						}
					}
					$this->ctd();
				}
			}
			if ($config['type'] == 'radio' && $config['mode'] == 'form') {
				$this->otd();
				$this->input('button', 'clear-'.$row['id'], 'Clear', 'class="clear-radio"');
				$this->ctd();	
			}
		}
		$this->ctable();
	  }


	/**
	 * Returns defined value of field in struct or empty string
	 */
	public function getValue($field, $defaultVal='', $struct=array()) {
		////If third argument provided, use that struct
		if (count($struct) > 0 && array_key_exists($field, $struct)) {
			return $struct[$field];
		///check both URL and Form scopes
		} else {
			if (array_key_exists($field, $_POST)) return $_POST[$field];
			if (array_key_exists($field, $_GET)) return $_GET[$field];
		}
		return $defaultVal;
	}

	/**
	 * Opens a form	
	 * @param	method	string	default="post" additional attributes
	 * @param	atts	string	default="" additional attributes
	 */	
	public function oform($action, $method='post', $atts='') {
		$atts = 'action="'.$action.'" method="'.$method.'"'.$this->fixAtts($atts);
		$this->otag('form', $atts);
	}

	/**
	 * Alias for getValue
	 */
	public function getVal($field, $defaultVal='', $struct=array()) {
		return $this->getValue($field, $defaultVal, $struct);
	}
	
	/**
	 * Opens a fieldset and legend tag	
	 */	
	public function ofieldset($legend, $atts='', $legendAtts='') {
		$this->otag('fieldset', $atts, true);
		$this->tag('legend', $legendAtts, $legend, true, false);
	}
	
	/**
	 * Creates a label
	 */
	public function label($id, $content, $atts='') {
		$atts = 'for="'.$id.'"' . $this->fixAtts($atts);
		$this->tag('label', $atts, $content, true);
	}


	/**
	 * Creates an input 
	 */
	public function input($type, $name, $value='', $atts='') {
		$atts = $this->fixAtts($atts);
		$addAtts = ' type="'.$type.'" name="'.$name.'"';
		if ($value != '') $addAtts .= ' value="'.$value.'"';
		$atts = $addAtts . $atts;
		$atts = $this->CheckId($name, $atts);
		$this->tag('input', $atts);
	}
	
	
	/**
	 * Creates a text area 	 
	 */
	public function textarea($name, $value='', $atts='', $rows=5, $cols=60) {
		$atts = ' name="'.$name.'" rows="'.$rows.'" cols="'.$cols.'"' . $this->fixAtts($atts); 
		$atts = $this->checkId($name, $atts);
		tag('textarea', $atts, $value, true, false);
	}	


	public function checkId($name, $atts) {
		if (strpos("id=", $atts) === false) $atts = ' id="'.$name.'"' . $this->fixAtts($atts);
		return $atts;
	}

	/**
	 * Creates a select dropdown
	 */
	public function select($name, $options, $selected='', $atts='', 
			$empty=false, $optionClassList='') {
		$atts = ' name="'.$name.'"' . $this->fixAtts($atts);
		$atts = $this->checkId($name, $atts);
		$this->otag('select', $atts, true);
		if ($empty) $this->tag('option', 'value=""', '', true, false);
		$this->renderOptions($options, $selected, $atts);
		$this->ctag('select', true);
	}
	
	public function datalist($name, $options, $selected='', $atts='', 
			$empty=false, $optionClassList='') {
		$this->tag('input', 'type="text" list=".'.$name.'" id="'.$name.'_text"', '', true);
		//$atts = $this->checkId($name, $atts);
		$this->otag('datalist', $atts, true);
		if ($empty) $this->tag('option', 'value=""', '', true, false);
		
		$this->renderOptions($options, $selected, $atts);
		$this->ctag('datalist', true);		

	}

	private function renderOptions($options, $selected='', $atts='', $optionClassList='') {
		$value="";
		$display="";
		$optionClass="";
		$selectIt="";
		$selected = explode(',', $selected);

		foreach ($options as $option) {
			if (strpos($option, "|") !== false) {
				if ($option == "|") {
					$value = "";
					$display = "";
				} else {
					if (substr($option, 0, 1) == "|") {
						$value = "";
						$display = substr($option, 1);	
					} else if (substr($option, -1) == "|") {
						$value = substr($option, 0, -1);
						$display = "";
					} else {
						list($value, $display) = explode('|', $option);
					}
				}
			} else {
				$value = $option;
				$display = $value;
			}
			if ($optionClassList != "") {
				$optionClassList = explose(',', $optionClassList);
				if ($i < count($optionClassList)) {
					$optionClass=' class="'.$optionClassList[$i].'"';			 
				} else {
					$optionClass="";
				}
			}
			$selectIt = (in_array($value, $selected)) ? ' selected="selected"' : '';
			//$selectIt = (ListFindNoCase(selected, value)) ? ' selected="selected"': "";
			$optAtts = 'value="'.$value.'"'.$selectIt.$optionClass;
			$this->tag('option', $optAtts, $display, true, false);
		}		
	}

	/**
	 * Created 11/29/2006 by Andy Hill
	 * Assuming file in question sets SES.hasCalendar to true in Directory Settings, creates a popUp Calendar
	 * the value of which will be submitted as "fieldname"
	 */
	public function calendar($name, $value='', $atts='') {
		$atts = $this->addClass($this->fixAtts($atts), "datepicker");
		if (strpos("size=", $atts) === false) $atts .= ' size="15"';
		$this->input('text', $name, $value, $atts);
	}

		public function choicegrid($Arguments, $openContainer = TRUE) {
			$i = 0;
			$tempArr = array();
			$Args = array();
			$defaults = array('type' => "checkbox", 
								'ids' => array(), 
								'selected' => array(), 
								'labelfirst' => false, 
								'attsAll' => "", 
								'atts' => array(), 
								'labelAttsAll' => "", 
								'labelAtts' => array(), 
								'container' => "none", 
								'containerAtts' => true, 
								'closeContainer' => true, 
								'numCols' => 0, 
								'selectall' => false, 
								'selectallInitState' => "select", 
								'textfields'=>array(), 
								'labelClass'=>''
			);		
			
			$name = $this->reqArgs("name", $Arguments); ////REQUIRED string - form name of checkbox set
			
			$vals = $this->reqArgs("vals", $Arguments);	////REQUIRED list - values for checkboxes/radoibuttons
			
			//print_r($vals);
			$Args = $this->extend($defaults, $Arguments);
			
			//print_r($Args);
			
			foreach ($Args as $arg => $value) {
				$$arg = $value;	
			}
			$hasAtts = count($atts) > 0;
			//print_r($Args);
			//echo "?".$labelClass."?</br>";
			//print_r($Arguments['selected']);
			//if (ListLen(labels) != ListLen(vals)) Request.utils.throw("Error in choicegrid. vals and labels not same length");		
			if (count($ids) != 0 && count($vals) != count($ids)) {
				echo "<script type='text/javascript'>alert('Error in choicegrid. vals and atts not same length')</script>";		
			}
			
			//echo '<br>'.$hasAtts." ".count($vals)." ".count($atts);
			/*if ($hasAtts && count($vals) != count($atts)) {
				echo "<script type='text/javascript'>alert('Error in choicegrid. vals and atts not same length')</script>";		
			}*/
			
			if (strtolower($selectallInitState) == "deselect") $selectClass .= " deselect";
			
			if ($selectall) $containerAtts = $this->combineClassAtts($containerAtts.' class="'.$selectClass.'"');
			
			if ($container == "table") $this->otable($containerAtts);
			else if ($container == "div" || ($container == "none" && $selectall)) $this->odiv($containerAtts);
			for ($i = 0; $i < count($vals); $i++) {
				//echo "<br>";
				$this->br();
				if ($container == "table") $this->otd();
				$value = $vals[$i];
				$labl = $value;
				$tempArr = explode("|", $value);
				if (count($tempArr) == 2) {
					$labl = $tempArr[1];
					$value = $tempArr[0];
				}
				$id = $name."_".$value;
				if (count($ids) > 0) {
					$id = $ids[$i];		
				}
				$lblAtt = $labelClass;// 'class="'.$labelClass.'"';
				//echo "1?".$lblAtt."?</br>";
				if (count($labelAtts) > $i) $lblAtt .= $this->fixAtts($labelAtts[$i]); 
				$lblAtt .= $this->fixAtts($labelAttsAll); 
				
				if ($labelfirst) $lblAtt .= $this->fixAtts($labelClass/*'class="'.$labelClass.'"'*/);
				//echo "2?".$lblAtt."?"."</br>";
				$lblAtt = $this->combineClassAtts($lblAtt);
				//echo "3?".$lblAtt."?</br>";
				if ($labelfirst) $this->label($id, $labl, $lblAtt);
				//echo "<br>Value: ".$value." Selected: ";
				//print_r($selected);
			//	echo "<br>".in_array("dummy", $selected);
				if (in_array($value, $selected) != FALSE) { 
					$attributes = ' checked="checked"';
				} else {
				//	$this->tbr("not found: ".$value);
					$attributes = "";
				}
				
				if ($hasAtts) $attributes .= $this->fixAtts($atts[$i]);
				if (strlen($attsAll)) $attributes .= $this->fixAtts($attsAll);
				$attributes = $this->combineClassAtts($attributes);
				//if (id != value) 
				$attributes .= $this->fixAtts('id="'.$id.'"');
				$this->input($type, $name, $value, $attributes);
				if (!$labelfirst) $this->label($id, $labl, $lblAtt);
				//$this->tbr($labl);
				//$this->pa($textfields);
				if (array_key_exists($labl, $textfields) || array_key_exists($labl.'|area', $textfields)) {
					if (array_key_exists($labl, $textfields)) {
						$this->intext($id.'_text', $textfields[$labl]);
					} else {
						$this->textarea($id.'_text', $textfields[$labl.'|area'], 'class="cdsAutoGrow" style="vertical-align: top;"', 1, 60); 
					}
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


	/**
 	 * Created by Andy Hill: 11/2005 
	 * Converts email to ASCII representations to discourage harvesting
	 * @param addr		string	default="SES-Tech@indiana.edu"	Email address to obfuscate
	 * @param display	string	default=addr 					Text to be displayed on screen (also obfuscated if the same as email)
	 **/
	public function email($addr, $display='') {
		$email = "";
		for ($i = 0; $i < strlen($addr); $i++) {
			$email = $email . "&#" . ord(substr($addr, $i, 1)) . ";";
		}
		if ($display == $addr) $display = $email;
		$mailto2 = "";
		$mailto = "mailto:";
		for ($i = 0; $i < strlen($mailto); $i++) {
			$mailto2 = $mailto2 . "&#" . ord(substr($mailto, $i, 1)) . ";";
		}
		$this->a($mailto2.$email, $display);
	}

	public function reqArgs($arg, $Arguments) {
		if (!array_key_exists($arg, $Arguments)) {
			$this->alert("required argument: '".$arg."' missing");
			//echo "<script type='text/javascript'>alert('Required argument '".$arg." missing.)</script>";	
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
			//$this->tbr("here1".$pre);
			//$this->tbr($classes);
			//$this->tbr($post);
			return $pre . ' class="'.$classes . " ". $class . '"' . $post;
		}
	}

	public function combineClassAtts($atts) {
		$i = 0; 
		$matches = array();
		$re = '/\s?class\s*=\s*"[^"]+"/';
		preg_match_all($re, $atts, $matches);
		if (count($matches) > 0) {
			$classes = array();
			$countMatches = count($matches[0]);
			for ($i = 0; $i < $countMatches; $i++) {
				$classes[$i] = preg_replace('/\s?class\s*=\s*"([^"]+)"/', "$1", $matches[0][$i]);		
			}
			$atts = preg_replace($re, "", $atts);
			$classes = array_unique($classes); 
			$atts = $atts . ' class="'.implode(' ', $classes).'"';
		}
		return $atts;
	}				


}
?>	
