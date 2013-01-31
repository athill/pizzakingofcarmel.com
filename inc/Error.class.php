<?php
class Error {
		private $logfile = "/error.log.txt";
		private $email = "athill@indiana.edu";
		
		// define an assoc array of error string
		// in reality the only entries we should
		// consider are E_WARNING, E_NOTICE, E_USER_ERROR,
		// E_USER_WARNING and E_USER_NOTICE
		private $errortype = array (
					E_ERROR              => 'Error',
					E_WARNING            => 'Warning',
					E_PARSE              => 'Parsing Error',
					E_NOTICE             => 'Notice',
					E_CORE_ERROR         => 'Core Error',
					E_CORE_WARNING       => 'Core Warning',
					E_COMPILE_ERROR      => 'Compile Error',
					E_COMPILE_WARNING    => 'Compile Warning',
					E_USER_ERROR         => 'User Error',
					E_USER_WARNING       => 'User Warning',
					E_USER_NOTICE        => 'User Notice',
					E_STRICT             => 'Runtime Notice',
					E_RECOVERABLE_ERROR  => 'Catchable Fatal Error'
		);


	function __construct($logfile = "") {
		//// we will do our own error handling
		if ($logfile != "") $this->logfile = $logfile;
		error_reporting(0);	
		$old_error_handler = set_error_handler(array($this, 'customErrorHandler'));
	}

	function customErrorHandler($errno, $errmsg, $filename, $linenum, $vars)  {
		// timestamp for the error entry
		$dt = date("Y-m-d H:i:s (T)");
	
		$stacktrace = $this->debug_string_backtrace();
		// set of errors for which a var trace will be saved
		$user_errors = array(E_USER_ERROR, E_USER_WARNING, E_USER_NOTICE);
		
		$err = "<errorentry>\n";
		$err .= "\t<datetime>" . $dt . "</datetime>\n";
		$err .= "\t<errornum>" . $errno . "</errornum>\n";
		$err .= "\t<errortype>" . $this->errortype[$errno] . "</errortype>\n";
		$err .= "\t<errormsg>" . $errmsg . "</errormsg>\n";
		$err .= "\t<scriptname>" . $filename . "</scriptname>\n";
		$err .= "\t<scriptlinenum>" . $linenum . "</scriptlinenum>\n";
		$err .= "\t<stacktrace>" . $stacktrace . "</stacktrace>\n";
		
		
	
		if (in_array($errno, $user_errors)) {
			$err .= "\t<vartrace>" . wddx_serialize_value($vars, "Variables") . "</vartrace>\n";
		}
		$err .= "</errorentry>\n\n";
		
		// for testing
		// echo $err;
	
		// save to the error log, and e-mail me if there is a critical user error
		error_log($err, 3, $this->logfile);
		if ($errno == E_USER_ERROR) {
			mail($this->email, "Critical User Error", $err);
		}		
		/*
		if (!(error_reporting() & $errno)) {
			// This error code is not included in error_reporting
			return;
		}
		*/
		
		if (!$GLOBALS['isPRD']) {
			echo "<strong>".$this->errortype[$errno].": $errmsg</strong><br /> in $filename line $linenum";
		}
		/*
		switch ($errno) {
		  case E_USER_ERROR:
			  echo "<b>My ERROR</b> [$errno] $errstr<br />\n";
			  echo "  Fatal error on line $errline in file $errfile";
			  echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
			  echo "Aborting...<br />\n";
			  exit(1);
			  break;
	  
		  case E_USER_WARNING:
			  echo "<b>My WARNING</b> [$errno] $errmsg<br />\n";
			  break;
	  
		  case E_USER_NOTICE:
			  echo "<b>My NOTICE</b> [$errno] $errmsg<br />\n";
			  break;
	  
		  default:
			  echo "Unknown error type: [$errno] $errmsg<br />\n";
			  break;
		}
		*/
	
		/* Don't execute PHP internal error handler */
		return true;
	}
	
    function debug_string_backtrace() {
        ob_start();
        debug_print_backtrace();
        $trace = ob_get_contents();
        ob_end_clean();

        // Remove first item from backtrace as it's this function which
        // is redundant.
        $trace = preg_replace ('/^#0\s+' . __FUNCTION__ . "[^\n]*\n/", '', $trace, 1);

        // Renumber backtrace items.
        $trace = preg_replace ('/^#(\d+)/me', '\'#\' . ($1 - 1)', $trace);

        return $trace;
    } 			
	
}
?>
