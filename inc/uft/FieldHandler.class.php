<?php
class FieldHandler {

	private $defaults = array();
	private $defs = array();
	private $data = array();

	// function __construct($defs, $data= array()) {

	// 	$this->defaults = array(
	// 		'global'=>array(
	// 			'required'=>array('name'),
	// 			'optional'=>array(
	// 				'fieldtype'=>'intext',
	// 				'label'=>'',
	// 				'atts'=>'',
	// 				'labelatts' =>'',
	// 				'value'=>''
	// 			)
	// 		),
	// 	);
	// }

	// function label($id) {
	// 	global $h;
	// 	$this->setDefaults($id);
	// 	$ff = $this->fields[$id];
	// 	$h->label($ff['name'], $ff['label'], $ff['labelatts']);
	// }

	// function field($ff) {
	// 	global $h;
	// 	$ff = $this->setDefaults($ff);
	// 	if (array_key_exists('value', $this->data)) {
	// 		$ff['value'] = $this->data['value'];
	// 	}
	// 	switch ($ff['fieldtype']) {
	// 		case 'textarea':
	// 			$h->textarea($ff['name'], $ff['value'], $ff['atts']);
	// 			break;
	// 	}
	// }

	// function setDefaults($id, $reset=false) {
	// 	if (!in_array($id, $this->fields)) {
	// 		throw new Exception('undefined id in setDefaults', 1);
			
	// 	}
	// 	$ff = $this->fields['id'];
	// 	if (array_key_exists('defaultsSet', $ff) && !$reset) {
	// 		return $ff;
	// 	}
	// 	// print_r($this->defaults['global']['required']);

	// 	foreach ($this->defaults['global']['required'] as $attr) {
	// 		if (!array_key_exists($attr, $ff)) {
	// 			echo 'required '.$attr.' missing';
	// 		}
	// 	}

	// 	foreach ($this->defaults['global']['optional'] as $attr => $val) {
	// 		if (!array_key_exists($attr, $ff)) {
	// 			$ff[$attr] = $this->defaults['global']['optional'][$attr];
	// 		}
	// 	}

	// 	$ff['defaultsSet'] = true;
	// 	return $ff;
	// }


}

?>