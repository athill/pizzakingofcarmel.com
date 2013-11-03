<?php
class FieldHandler {

	private $defaults = array();
	private $defs = array();
	private $data = array();
	private $original = array();
	private $anonIndex = 0;
	private $seriesIndices = array();

	function __construct($defs, $opts= array()) {
		global $h;
		$this->defs = $defs;
		$this->original = $defs;
		$defaults = array(
			'data'=>array(),
			'opts'=>array(),

		);
		$opts = $h->extend($defaults, $opts);
		$this->data = $opts['data'];
		$optDefaults = array(
			'colonafterlabel'=>true,
			'prefix'=>'',
			'series'=>false
		);
		$this->opts = $h->extend($optDefaults, $opts['opts']);
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
			'index'=>-1,
			'divatts'=>'',
			'labelfirst'=>true
		);

		$opts = $h->extend($defaults, $opts);
		$ff = $this->setDefaults($id);
		//// attributes
		$divatts = 'id="'.$ff['id'].'_div"'.$h->fixAtts($opts['divatts']);
		$h->odiv($divatts);
		if ($opts['labelfirst']) {
			$this->label($id, $opts);	
		}
		$this->field($id, $opts);
		if (!$opts['labelfirst']) {
			$this->label($id, $opts);	
		}		
		
		$h->cdiv('/#'.$divid);

	}


	function label($id, $opts=array()) {
		global $h;
		$defaults = array(
			'index'=>-1
		);
		$opts = $h->extend($defaults, $opts);
		$ff = $this->setDefaults($id);
		$label = ($this->opts['colonafterlabel']) ? $ff['label'].':' : $ff['label'];
		$h->label($ff['id'], $label, $ff['labelatts']);
	}

	function getId($ff) {
		$id = $ff['name'];
		if ($this->opts['series']) {
			if (array_key_exists($id, $this->seriesIndices)) {
				$this->seriesIndices[$id] = 0;
			} else {
				$this->seriesIndices[$id]++;
			}
			$id .= '-'.$this->seriesIndices[$id];
		}
		return $id;
	}

	function field($id, $opts=array()) {
		global $h;
		$defaults = array(
			'index'=>-1
		);
		$opts = $h->extend($defaults, $opts);
		$ff = $this->setDefaults($id);
		if (array_key_exists('value', $this->data)) {
			$ff['value'] = $this->data['value'];
		}
		//$ff['atts'] .= ' id="'.$this->getId($ff).'"';
		$id = $ff['id'];
		$type = $ff['fieldtype'];
		$atts = $ff['atts'];
		switch ($ff['fieldtype']) {
			case 'textarea':
				$h->textarea($id, $ff['value'], $ff['atts']);
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
				$h->input($type, $id, $ff['value'], $atts);
				break;
			case 'checkbox':
				$h->input($type, $id, $ff['value'], $atts);
				break;		
			case 'select':
				$h->select($id, $ff['options'], $ff['value'], $ff['atts']);
				break;
			default:
				# code...
				break;				
		}
	}

	function setDefaults($id, $reset=false) {
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

		$ff['id'] = $this->getId($ff);
		
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
		$ff['value'] = $this->getValue($ff['value']);

		$ff['defaultsSet'] = true;
		$this->defs[$ff['name']] = $ff;
		return $ff;
	}

	function getValue($field_id) {
		if (array_key_exists('value', $this->defs[$field_id])) {
			return $this->defs[$field_id]['value'];
		} else if (array_key_exists($field_id, $this->data)) {
			return $this->data[$field_id];	
		} else if (array_key_exists('defaultVal', $this->defs[$field_id])) {
			return $this->defs[$field_id]['defaultVal'];
		} else {
			return '';
		}
	}	
}

?>