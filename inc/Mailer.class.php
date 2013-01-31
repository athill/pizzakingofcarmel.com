<?php
class Mailer {
	public $from = "uirr@indiana.edu";
	public $type = "html";
	private $defaultEmail = "athill@indiana.edu"; 
	public $bcc = "";
		
	function __construct() {
		if (!array_key_exists('isPRD', $GLOBALS)) $GLOBALS['isPRD'] = $_SERVER['HTTP_HOST'] !== "webtest.iu.edu";
	}
		
	public function send($to, $subject, $content, $cc="") {
		
		$headers = array();
		
		$isPRD = $GLOBALS['isPRD'];
		$wouldSendTo = "";
		
		if ($this->type == "html") {
			$headers[]  = 'MIME-Version: 1.0';
			$headers[]= 'Content-type: text/html; charset=iso-8859-1';	
		}
		$headers[] = 'From: ' . $this->from;
		
		if (!$isPRD) {
			$wouldSendTo = $to;
			if (array_key_exists('REMOTE_USER', $_SERVER)) {
				$data = $GLOBALS['ads']->getUserData($_SERVER['REMOTE_USER']);	
				$to = $data['email'];
			}
			$content .= "<br />Would be sent to: ".$wouldSendTo;
			$to = $this->defaultEmail;
		} 
		
		if ($cc != "") {
			if (!$isPRD) $wouldSendTo .= "," . $cc;
			else $headers[] = "Cc: " . $cc;	
		}
		if ($this-bcc != "") {
			if (!$isPRD) $wouldSendTo .= "," . $this->bcc;
			else $headers[] = "Bcc: " . $this->bcc;	
		}
		//print_r($headers);
		$headers = $this->getHeaders($headers);
		//print($headers);
		mail($to, $subject, $content, $headers);
		
	}
	
	private function getHeaders($headers) {
		$str = "";
		foreach ($headers as $header) {
			$str .= $header . "\r\n";
		}
		return $str;
	}
}
?>