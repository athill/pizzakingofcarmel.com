<?php
/**
* 
*/
class FormHandler {


	function __construct($fieldhandler, $opts=array()) {
		global $h;
		$this->fh = $fieldhandler;
		$defaults = array(
			'action'=>'submit.php',
			'method'=>'post',
			'class'=>'uft-form',
			'upload'=>false,
			'atts'=>'',
			'id'=>'',
			'rowtype'=>'div' //div|tr|none
		);
		$this->opts = $h->extend($defaults, $opts);
	}

	function oform() {
		global $h;
		$atts = '';
		$opts = $this->opts;
		foreach (array('class', 'id') as $att) {
			// $h->tbr($att.': '.$formatts[$att]);
			if ($opts[$att] == '') continue;
			$atts = $h->addAtt($atts, $att, $opts[$att]);
		}

		if ($opts['upload']) {
			$atts = $h->addAtt($atts, 'enctype', 'multipart/form-data');	
		}
		if ($opts['atts'] != '') {
			$atts = $h->addAtt($atts, $opts['atts']);
		}
		$h->oform($opts['action'], $opts['method'], $atts);
	}

	function rows($rows) {
		foreach ($rows as $row) {
			echo 'row!';
			$this->row($row);
		}
	}




	function cform() {
		global $h;
		$comment = $this->opts['formatts']['id'] == '' ? '' : '/#'.$this->opts['formatts']['id'];
		$h->cform($comment);
	}
}
?>