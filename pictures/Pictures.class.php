<?php
class Pictures {


	function getId($name) {
		$new_id = preg_replace('/\W/', '', $name);
	}
}
?>