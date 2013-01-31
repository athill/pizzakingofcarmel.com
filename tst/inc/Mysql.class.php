<?php
class mysql {
                private $connection;
                private $database = "Requests2";
                public $recordCount = 0;
                public $fields;
                public $month, $day, $year;
                function __construct($db="") {
                                                ////open connection
                                                $this->connection = mysql_connect("mysql.iu.edu:3206", "urr", "dpd72gr");                                    

                                                if (!$this->connection) {
                                                                 die('Could not connect: ' . mysql_error());
                                                }
                                                ////select database
                                                if ($db === "") $db = $this->database;
                                                $this->db($db);
                }
               

                public function db($database) {
                                $db_selected = mysql_select_db($database, $this->connection);
                                if (!$db_selected) {
                                die ('Can\'t use '.$database.' : ' . mysql_error());
                                }
                                $this->database = $database;
                }

                public function query($sql) {
                                                $result = mysql_query($sql, $this->connection);
                                                if (!$result) {
                                                die('Invalid query: ' . mysql_error());
                                                }
                                                $this->recordCount = mysql_num_rows($result);
                                                $res = array();
                                                while ($row = mysql_fetch_assoc($result)) {
                                                                $res[] = $row;   
                                                }
                                                mysql_free_result($result);
                                                return $res;
                }

                // $string: query
                public function mysql_queryf($string)    //to insert arguments in a query
                {
                                $args = func_get_args();               // gets the arguments passed to this function
                                array_shift($args);                           // remove the first argument (query)
                                $len = strlen($string);
                                $sql_query = "";
                                $args_i = 0;
                                $args_j = 0;
                                for($i = 0; $i < $len; $i++)
                                {
                                                if($string[$i] == "%")
                                                {
                                                                $char = $string[$i + 1];
                                                                $i++;
                                                                switch($char)
                                                                {
                                                                                case "%":
                                                                                                $sql_query .= $char;
                                                                                                break;
                                                                                case "u":
                                                                                                $sql_query .= "'" . intval($args[$args_i][$args_j]) . "'";
                                                                                                break;
                                                                                case "s":                                                                                              
                                                                                                $sql_query .= "'" . mysql_real_escape_string($args[$args_i][$args_j]) . "'";
                                                                                                break;
                                                                                case "x":
                                                                                                $sql_query .= "'" . dechex($args[$args_i][$args_j]) . "'";
                                                                                                break;
                                                                }
                                                                if($char != "x")
                                                                {
                                                                                //$args_i++;
                                                                                $args_j++;
                                                                }
                                                }
                                                else
                                                {
                                                                $sql_query .= $string[$i];
                                                }
                                }
                                return $sql_query;
                }
               
                // $sql: query
                // $args: array containing condition values
                public function safequery($sql, $args) {                                                                                                                                                
                                                $sql = $this->mysql_queryf($sql,$args);
                                                $result = mysql_query($sql, $this->connection);
                                                if (!$result) {
                                                die('Invalid query: ' . mysql_error());
                                                }
                                                $this->recordCount = mysql_num_rows($result);
                                                $res = array();
                                                $fieldNames = array();
                                                while ($row = mysql_fetch_assoc($result)) {                       
                                                                $res[] = $row;   
                                                                $this->fields = array_keys($row);
                                                }
                                                mysql_free_result($result);
                                                return $res;
                }
                // $table: table name in which insertion is to be dome
                // $args: associative array containing column names as keys and their corresponding values
                function insert($table, $args) {  
                                foreach ($args as $field => &$value) {
                                                                $class = get_class($value);                                          
                                                               if($class == 'DateTime') {                                                                                                                                              
                                                                                $value = $value->format('Y-m-d H:i:s');
                                                                }
                                }                             
                                $values = array_map('mysql_real_escape_string', array_values($args));
                $keys = array_keys($args);
                    $result = mysql_query('INSERT INTO `'.$table.'` (`'.implode('`,`', $keys).'`) VALUES (\''.implode('\',\'', $values).'\')');
                }
            
                // $table: table to be updated
                // $args: associative array containing column names as keys and their corresponding values
                // $where: where clause
                function update($table, $args, $where) {
                                  foreach ($args as $field => $value) {
                                               $value = mysql_real_escape_string($value);      
                                                $fields .= "$field = '$value', ";                                                    
                                  }           
                                  // remove trailing ", " from $fields and $values
                                  $fields = preg_replace('/, $/', '', $fields);
                                  $values = preg_replace('/, $/', '', $values);
                                  $sql = "UPDATE $table SET $fields WHERE $where";
                                  $result = mysql_query($sql);
                }


                public function close() {
                                mysql_close($this->connection);
                }
}
?>
