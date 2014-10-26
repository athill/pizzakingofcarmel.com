<?php

if ($site['filename'] == "index.php") {
	$site['pageTitle'] = "";
} else if ($site['filename'] == "contact.php") {
	$site['pageTitle'] = "Contact Us";
} else if ($site['filename'] == "menu.php") {
	$site['tooltip'] = true;	
} else if ($site['filename'] == "pictures.php") {
	$site['lightbox'] = true;
}
?>
