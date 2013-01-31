<?php

if ($GLOBALS['filename'] == "index.php") {
	$GLOBALS['pageTitle'] = "";
} else if ($GLOBALS['filename'] == "contact.php") {
	$GLOBALS['pageTitle'] = "Contact Us";
} else if ($GLOBALS['filename'] == "menu.php") {
	$GLOBALS['tooltip'] = true;	
} else if ($GLOBALS['filename'] == "pictures.php") {
	$GLOBALS['lightbox'] = true;
}
?>
