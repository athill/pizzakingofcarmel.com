<?php
/**
* 
*/
include('FormHandler.class.php');
class UftGrid extends FormHandler {
	
	function __construct($fieldhandler, $opts=array()) {
		$opts['class'] = 'uft-grid';
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
		$layout = array();
		if (array_key_exists('layout', $ids)) {
			$layout = $ids['layout'];
			$ids = $ids['fields'];
		}
		$class = 'p'.intval(100/count($ids));
		foreach ($ids as $i => $id) {
			$cls = array_key_exists($i, $layout) ? 
				'p'.$layout[$i] : 
				$class;
			$this->fh->fieldpair($id, array('divatts'=>'class="'.$cls.'"'));
		}
		$h->cdiv('/.uft-row');
	}
}
?>

