<?php
class Formfield {

	private $defaults = array();

	function __construct() {
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

	function label($ff) {
		global $h;
		$ff = $this->setDefaults($ff);
		$h->label($ff['name'], $ff['label'], $ff['labelatts']);
	}

	function field($ff) {
		global $h;
		$ff = $this->setDefaults($ff);
		switch ($ff['fieldtype']) {
			case 'textarea':
				$h->textarea($ff['name'], $ff['value'], $ff['atts']);
				break;
		}
	}

	function setDefaults($ff, $reset=false) {
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

		$ff['defaultsSet'] = true;
		return $ff;
	}


}

?>