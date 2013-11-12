<?php
class FieldHandler {

	private $defaults = array();		//// defaults on a per-field basis
	private $defs = array();			//// field definitions; override defaults and opts
	private $data = array();			//// field values: $k=>$v or indexed array $k=>$v
	private $opts = array();			//// defaults for all fields, can be overriddeen at field level
	private $original = array();		//// copy of defs before it's altered
	private $anonIndex = 0;				//// suffix for fields generated on the fly without a name
	private $seriesIndices = array();	//// used in series. TODO: review how it works


	//// defs, see above; opts: split into data and opts, see above
	function __construct($defs, $opts= array()) {
		global $h;
		$this->defs = $defs;
		$this->original = $defs;
		$defaults = array(
			'data'=>array(),
			'opts'=>array(
				'colonafterlabel'=>true,
				'prefix'=>'',				////TODO	
				'series'=>false,			////Not sure should apply per field
				'labelfirst'=>true,
			),

		);
		$opts = $h->extend($defaults, $opts);
		$this->data = $opts['data'];
		$this->opts = $opts['opts'];
		
		$this->defaults = array(
			'global'=>array(
				'required'=>array('name'),
				'optional'=>array(
					'fieldtype'=>'intext',
					'label'=>'',
					'atts'=>'',
					'labelatts' =>'',
					'value'=>''
				)
			),
		);
	}




	function fieldpair($id, $opts=array()) {
		global $h;
		$defaults = array(
			'container'=>'div',	////div,li,none,tr1,tr2,td1,td2
			'divatts'=>'',
		);

		$opts = $h->extend($defaults, $opts);
		$ff = $this->setDefaults($id);
		$ff['id'] = $this->getId($ff);
		//// attributes
		$divatts = 'id="'.$ff['id'].'_wrapper"'.$h->fixAtts($opts['divatts']);
		$this->ocontainer($opts['container'], $divatts);
		if ($ff['labelfirst']) {
			$this->label($id, $opts);	
			$this->cocontainer($opts['container']);
		}
		$this->field($id, $opts);
		if (!$ff['labelfirst']) {
			$ff['colonafterlabel'] = false;
			$this->cocontainer($opts['container']);
			$this->label($id, $opts);	
		}		
		
		$this->ccontainer($opts['container'], $ff['id']);

	}

	private function ocontainer($container, $atts='') {
		global $h;
		if ($container == 'none') return;
		$c = preg_replace('/(\w+)\d$/', '$1', $container);
		if (in_array($c, array('div', 'li', 'tr'))) {
			call_user_func(array($h, 'o'.$c), $atts);		
		}
		if (in_array($c, array('tr', 'td'))) {
			$num = preg_replace('/\w+(\d)$/', '$1', $container);
			if ($num == 1) {
				$atts = $c == 'td' ? $atts : '';
				$h->otd($atts);
			} else {
				$h->oth();
			}
		}

	}

	private function cocontainer($container, $id) {
		global $h;
		if ($container == 'none') return;
		$c = preg_replace('/(\w+)\d$/', '$1', $container);
		if (in_array($c, array('tr', 'td'))) {
			$num = preg_replace('/\w+(\d)$/', '$1', $container);
			if ($num == 1) {
				$h->otd();
			} else {
				$h->oth();
			}
		}
	}

	private function ccontainer($container, $id) {
		global $h;
		if ($container == 'none') return;
		$c = preg_replace('/(\w+)\d$/', '$1', $container);
		if (in_array($c, array('tr', 'td'))) {
			$num = preg_replace('/\w+(\d)$/', '$1', $container);
			$id = $c == 'td' && $num == 1 ? $id : '';
			$h->ctd($id);
		}
		if (in_array($c, array('div', 'li', 'tr'))) {
			call_user_func(array($h, 'c'.$c), '/#'.$id);		
		}

	}


	function label($id, $opts=array()) {
		global $h;
		$defaults = array(
			'index'=>-1
		);
		$opts = $h->extend($defaults, $opts);
		$ff = $this->setDefaults($id);
		$label = ($ff['colonafterlabel']) ? $ff['label'].':' : $ff['label'];
		$h->label($ff['id'], $label, $ff['labelatts']);
	}

	function field($id, $opts=array()) {
		global $h;
		$defaults = array(
			'index'=>-1
		);
		$opts = $h->extend($defaults, $opts);
		$ff = $this->setDefaults($id);
		$value = $this->getValue($id);
		//$ff['atts'] .= ' id="'.$this->getId($ff).'"';
		$id = $ff['id'];
		$type = $ff['fieldtype'];
		$atts = $ff['atts'];
		switch ($ff['fieldtype']) {
			case 'textarea':
				$h->textarea($id, $value, $atts);
				break;
			case 'intext':
			case 'phone':
			case 'date':
			case 'email':
			case 'number':
				$type = ($ff['fieldtype'] == 'intext') ? 'text': $ff['fieldtype'];
				if (array_key_exists('size', $ff)) {
					$atts = $this->addAtt($atts, 'size="'.$ff['size'].'"');
				}
				if (array_key_exists('maxlength', $ff)) {
					$atts = $this->addAtt($atts, 'maxlength="'.$ff['maxlength'].'"');
				}
				if ($type == 'date') {
					$atts = $h->addClass($atts, 'datepicker');
				}
				$h->input($type, $id, $value, $atts);
				break;
			case 'checkbox':
				$h->input($type, $id, $value, $atts);
				break;		
			case 'select':
				$h->select($id, $ff['options'], $value, $ff['atts']);
				break;
			default:
				# code...
				break;				
		}
	}

	function setDefaults($id, $reset=false) {
		global $h;
		$ff = array();
		if (!is_array($id)) {
			if (!array_key_exists($id, $this->defs)) {
				echo $id;
				print_r($this->defs);
				//throw new Exception('undefined id in setDefaults', 1);	
			} else {
				$ff = $this->defs[$id];
				// print_r($ff);
				$ff['name'] = $id;
				
			}
		} else {
			$ff = $id;
			if (!array_key_exists('name', $ff)) {
				$ff['name'] = 'anon'.$this->anonIndex++;
			}
		}
		
		if (array_key_exists('defaultsSet', $ff) && !$reset) {
			return $ff;
		}		

		// print_r($this->defaults['global']['required']);

		foreach ($this->defaults['global']['required'] as $attr) {
			if (!array_key_exists($attr, $ff)) {
				echo 'required '.$attr.' missing';
			}
		}

		foreach ($this->defaults['global']['optional'] as $attr => $val) {
			if (!array_key_exists($attr, $ff)) {
				$ff[$attr] = $this->defaults['global']['optional'][$attr];
			}
		}
		// $ff['value'] = $this->getValue($ff['value']);
		$ff = $h->extend($this->opts, $ff);

		$ff['defaultsSet'] = true;
		$this->defs[$ff['name']] = $ff;
		return $ff;
	}

	function getValue($field_id) {
		global $h;
		// $h->tbr('?'.$this->opts['series']);
		if (array_key_exists('value', $this->defs[$field_id]) && $this->defs[$field_id]['value'] != '') {
			return $this->defs[$field_id]['value'];
		} else if (array_key_exists($field_id, $this->data)) {
			return $this->data[$field_id];	
		} else if ($this->opts['series'] && array_key_exists($field_id, $this->seriesIndices) 
				&& array_key_exists($field_id, $this->data[$this->seriesIndices[$field_id]])) {
			return $this->data[$this->seriesIndices[$field_id]][$field_id];
		} else if (array_key_exists('defaultVal', $this->defs[$field_id])) {
			return $this->defs[$field_id]['defaultVal'];
		} else {
			return '';
		}
	}	

	public function attr() {
		
	}


	function getId($ff) {
		$id = $ff['name'];
		if ($this->opts['series']) {
			// print_r($this->seriesIndices);
			if (!array_key_exists($id, $this->seriesIndices)) {
				// echo 'here 0';
				$this->seriesIndices[$id] = 0;
			} else {
				// echo 'here ++';
				$this->seriesIndices[$id]++;
			}
			$id .= '-'.$this->seriesIndices[$id];
		}
		$this->defs[$ff['name']]['id'] = $id;
		return $id;
	}	
}

?>