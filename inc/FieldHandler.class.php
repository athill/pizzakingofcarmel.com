<?php
$h = $GLOBALS['h'];

class FieldHandler {
	public $defs = array();
	public $data = array();

	function __construct($defs, $data = array()) {
		$this->defs = $defs;
		$this->data = $data;
	}

	function renderField($field_id, $atts='') {
		global $h;
		$field = $this->defs[$field_id];
		if (array_key_exists('fieldatts', $field)) {
			$atts = $this->addAtt($atts, $field['fieldatts']);
		}
		$value = $this->getValue($field_id);
		$type = $field['fieldtype'];
		switch ($type) {
			case 'intext':
			case 'phone':
			case 'date':
			case 'email':
			case 'number':
				$type = ($type == 'intext') ? 'text': $type;
				if (array_key_exists('size', $field)) {
					$atts = $this->addAtt($atts, 'size="'.$field['size'].'"');
				}
				if (array_key_exists('maxlength', $field)) {
					$atts = $this->addAtt($atts, 'maxlength="'.$field['maxlength'].'"');
				}
				if ($type == 'date') {
					$atts = $h->addClass($atts, 'datepicker');
				}
				$h->input($type, $field_id, $value, $atts);
				break;
			case 'checkbox':
				$h->input($type, $field_id, $value, $atts);
				break;
			case 'textarea':
				$h->textarea($field_id, $value, $atts);
				break;
			case 'select':
				$h->select($field_id, $field['options'], $value, $atts);
				break;
			default:
				# code...
				break;
		}
	}

	function renderLabel($field_id, $atts='') {
		global $h;
		$label = array_key_exists('label', $this->defs[$field_id]) ? $this->defs[$field_id]['label'] : '';
		if ($label == '') {
			return;
		}
		$h->label($field_id, $label, $atts);
		$required = (array_key_exists('required', $this->defs[$field_id])) ? 
			$this->defs[$field_id]['required'] :
			false;
		if ($required) {
			$h->span('*', 'class="required"');
		}
	}

	function inline($field_id) {
		$this->renderLabel($field_id);
		$this->renderField($field_id);
	}

	function inline_r($field_id) {
		$this->renderField($field_id);
		$this->renderLabel($field_id);
	}

	function twoline($field_id)	{
		global $h;
		$this->renderLabel($field_id);
		$h->br();
		$this->renderField($field_id);		
	}

	function row($field_id) {
		global $h;
		$h->oth();
		$this->renderLabel($field_id);
		$h->cth();
		$h->otd();
		$this->renderField($field_id);
		$h->ctd();
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

	private function addAtt($atts, $att) {
		return ($atts == '') ? $att : $atts . ' '.$att;
	}

	// function initField($fieldname) {
	// 	$options = array(
	// 		'required'=>array(),
	// 		'defaults'=>array(
	// 			'id'=>$fieldname,
	// 			'label'=>''
	// 		),
	// 		'fieldtypes'=>array(
	// 			'select'=>array(
	// 				'required'=>array('options'),
	// 				'defaults'=>array()
	// 			)

	// 		)
			

	// 	);
	// 	foreach ($options as $key => $value) {
	// 		# code...
	// 	}
	// }

}


?>