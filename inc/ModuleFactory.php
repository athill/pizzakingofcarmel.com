<?php
class ModuleFactory {
	var $jsfiles = array();
	var $cssfiles = array();
	var $modules = array();
	var $obs = array();
	var $moduleDir = "";



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
		$this->moduleDir = $GLOBALS['fileroot'] . "/inc/modules/";
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

	function add($name, $args = array()) {
		if (!in_array($name, $this->modules)) {
			////include the file
			$inc = $this->moduleDir . $name . ".php";
			include_once($inc);	
			////Instantiate the object	
			$ob = null;
			$str = '$ob = new ' . $name . '('; 
			for ($i = 0; $i < count($args); $i++) {
				$str .= '"'.$args[$i].'"';
				if ($i < count($args) - 1) $str .= ", ";
			}	
			$str .= ');';
			//print($str);
			eval($str);
			////Add the object to the inventory
			$this->jsfiles = $this->addScripts($this->jsfiles, $ob->jsfiles); 
			$this->cssfiles = $this->addScripts($this->cssfiles, $ob->cssfiles);
			$key = ($name == "Module") ? $ob->name : $name;	
			$this->modules[] = $key;
			$this->obs[$key] = $ob;
		}
	}

	function addScripts($current, $new) {
		$new = explode(",", $new);
				
		for ($i = 0; $i < count($new); $i++) {
			$current[] = $new[$i];
		}
		return array_unique($current);
	}
}
?>
