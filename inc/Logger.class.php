<?php
class Logger {
	private $logdir = "/ip/uirr/logs";
	private $ext = ".log.txt";
	private $delim = ",";
	private $nl = "\n";
	
	public function add($type, $message="") {
		$fp = fopen($this->logdir."/".$type.$this->ext, 'a');
		$items = array(
			date("Y/m/d h:i:s"),
			$_SERVER['SCRIPT_FILENAME'],
			$message
		);
		$str = $this->buildString($items);
		
		fwrite($fp, $str);
		fclose($fp); 	
	}
	
	private function buildString($items) {
		$items = array_map(array($this, 'formatString'), $items);
		print_r($items);
		return implode($this->delim, $items).$this->nl;	
	}
	
	private function formatString($string) {
		$string = str_replace('"', '""', $string);
		return '"'.$string.'"';	
		
	}
}
?>