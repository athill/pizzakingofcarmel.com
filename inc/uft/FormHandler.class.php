<?php
/**
* 
*/
class FormHandler {


	function __construct($fieldhandler, $opts=array()) {
		global $h;
		$this->fh = $fieldhandler;
		$defaults = array(
			'formatts'=>array(
				'action'=>'submit.php',
				'method'=>'post',
				'class'=>'uft-form',
				'enctype'=>'',
				'atts'=>'',
				'id'=>''
			),
			'rowtype'=>'div' //div|tr|none
		);
		$this->opts = $h->extend($defaults, $opts);
	}

	function oform() {
		global $h;
		$formatts = $this->opts['formatts'];
		$atts = '';
		foreach (array('class', 'enctype', 'id') as $att) {
			// $h->tbr($att.': '.$formatts[$att]);
			if ($formatts[$att] == '') continue;
			$atts = $h->addAtt($atts, $att, $formatts[$att]);
		}
		$atts = $h->fixAtts($atts, $formatts['atts']);
		$h->oform($formatts['action'], $formatts['method'], $atts);
	}

	function row($ids, $opts=array()) {
		global $h;
		// $defaults = array(
		// 	'rowtype'=>$this['opts']['rowtype'],
		// 	'atts'='',
		// 	'class'=>''
		// );
		// $opts = $h->extend($defaults, $opts);	
		// $atts = $opts['atts'];
		// if ($opts['class'] != '') {
		// 	$atts = $h->addClass($atts, $class);
		// }
		// call_user_func(array($h, 'o'.$this->opts['rowtype']), $atts);
		// foreach ($ids as $id) {
		// 	$this->fh->fieldpair($id);
		// }
		// call_user_func(array($h, 'c'.$this->opts['rowtype']), $atts);
	}

	function cform() {
		global $h;
		$comment = $this->opts['formatts']['id'] == '' ? '' : '/#'.$this->opts['formatts']['id'];
		$h->cform($comment);
	}
}
?>