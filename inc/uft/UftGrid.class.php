<?php
/**
* 
*/
include('FormHandler.class.php');
class UftGrid extends FormHandler {
	
	function __construct($fieldhandler, $opts=array()) {
		parent::__construct($fieldhandler, $opts);
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
		if (!is_array($ids)) $ids = array($ids);
		$h->odiv('class="uft-row"');
		foreach ($ids as $id) {
			$this->fh->fieldpair($id);
		}
		$h->cdiv('/.uft-row');

		// call_user_func(array($h, 'o'.$this->opts['rowtype']), $atts);
		// foreach ($ids as $id) {
		// 	$this->fh->fieldpair($id);
		// }
		// call_user_func(array($h, 'c'.$this->opts['rowtype']), $atts);
	}
}
?>

