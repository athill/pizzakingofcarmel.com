<?php
spl_autoload_register('my_autoloader');

function my_autoloader($class_name) {
	global $site;		
    //class directories
    $directories = array(
        $site['incroot'].'/',
    );
    $class_name = str_replace('_', '/', $class_name);
    // echo $class_name.'<br>';
    //for each directory
    foreach($directories as $directory) {
        //see if the file exsists
        $file = $directory.$class_name . '.class.php';
        // echo $file;
        if(file_exists($file)) {
            require_once($file);
            //only require the class once, so quit after to save effort (if you got more, then name them something else
            return;
        }           
    }
 }

?>