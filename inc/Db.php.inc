<?php
//connect to db

//$dbh=mysql_connect ($server, $username, $password) or die ('I cannot connect to the database because: ' . mysql_error());
//mysql_select_db ($database) or die("Couldn't select db"); 


/**
 * DB stuff
 *
 * 
 *
 * @package includes
 * @author andy hill 2 2010
 * @version 1.0
 *
 */

class Db {
	 	
 	/**
	 * Login info 
	 *
	 */  
 	var $server = "localhost";
	var $username = "andyhil_andy";
	var $password = "h0p313ss";
	var $database = "andyhil_main";
 	
 	/**
	 * buffer
	 *
	 * @var object
	 */  
 	var $buffer;
 	

	/*********************
 	 * output or no
         */
	var $output;

	var $strictIndent;

 	/**
	 * Hold an instance of the class
	 *
	 * @var object
	 */  
	private static $instance;
 	
 	/**
	 * constructor
	 *
	 * create an instance of the Logger class
	 * pass in the persistence type(i.e. database, file, standard out)
	 * have a factory create the persistence object that log events are sent to
	 *
	 * @param string
	 */ 
 	function __construct() {
		/* 		
		$this->       = 0;
 		$this->buffer      = "";
		$this->output      = true;
		$this->strictIndent = true;
		*/ 	
		$dbh=mysql_connect ($this->server, $this->username, $this->password) or die ('I cannot connect to the database because: ' . mysql_error());
		mysql_select_db ($this->database) or die("Couldn't select db"); 				
	}	
	
	
	public static function singleton() {
        if (!isset(self::$instance)) {
            $c = __CLASS__;
            self::$instance = new $c;
        }
        return self::$instance;
    }
    
    
    public function __clone() {
        trigger_error('Clone is not allowed.', E_USER_ERROR);
    }
	
	/******************************************************
	 * Start buffering results of functions rather than outputting
	 ******************************************************/
	 public function startBuffer($buffer="") {
	 	$this->buffer = $buffer;
	 	$this->output = false;
	 }



}
?>
