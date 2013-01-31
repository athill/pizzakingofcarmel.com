<?php
function doApplet($codebase, $class, $height=400, $width=400) {
	print("<!--[if !IE]>-->
	<object classid=\"java:$class\" 
		  type=\"application/x-java-applet\"
		  height=\"$height\" width=\"$width\" >
	<param name=\"codebase\" value=\"$codebase\" />
	<!--<![endif]-->
	<object classid=\"clsid:8AD9C840-044E-11D1-B3E9-00805F499D93\" 
			height=\"$height\" width=\"$width\" > 
	  <param name=\"codebase\" value=\"$codebase\" />
	  <param name=\"code\" value=\"$class\" />
	</object> 
	<!--[if !IE]>-->
	</object>
	<!--<![endif]-->\n");
}

function doLink($val, $subdir) {
	global $webroot;
	print("<a href=\"" . $GLOBALS['webroot'] . "/index.php?view=" . $subdir . 
		$val['attributes']['HREF'] . "\">" . $val['attributes']['DISPLAY'] . "</a>");
}

function aLink($href, $display) {
	global $webroot;
	print("<a href=\"" . $GLOBALS['webroot'] . "/index.php?view=" . $href . "\">" . $display . "</a>");	
}
?>