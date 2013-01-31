<?php
//print("Path: ");
$path = "";
/*
if (!preg_match("/\/home\//", $GLOBALS['view']))  {
	print("<a href=\"$webroot/index.php?view=/home/\">Home</a> &gt;&gt; ");
}
*/	
//print_r($GLOBALS['script']);
/*
print("<pre>");
print_r($vals);
print("<pre>");
*/

// displays all the file nodes
if(!$xml=simplexml_load_file($fileroot . '/menu.xml')){
    trigger_error('Error reading XML file',E_USER_ERROR);
}
//print_r($GLOBALS['script']);
$path = buildPath($xml);
//print("???");
//print_r($path);


displayPath($path);

function displayPath($nodes) {
	global $h;
	global $webroot;
	$h->top("PATH: ");
	if (!preg_match("/\/home\//", $GLOBALS['view'])) {
		$h->local('/home/', "Home");
		$h->op(" &gt;&gt; ");	
	}
	for ($i = 0; $i < count($nodes); $i++) {
		$h->op($nodes[$i]);
		if ($i < count($nodes) - 1) $h->op(" &gt;&gt; ");
	}
	$h->op("\n");
}




function buildPath($xml, $path="", $depth=0, $nodes=array()) {
	global $h;
	foreach ($xml as $elem) {
		$node = preg_replace("/\//", "", $elem['href']);
		if ($node == $GLOBALS['script'][$depth]) {		
			$path .= $elem['href'];
			$type = $elem->getName();
			if ($depth + 1 == count($GLOBALS['script'])) {
				$nodes[] = $elem['display'];
				return $nodes;
			} else {
				$h->startBuffer();
				$h->local($path, $elem['display'], '');	
				$nodes[] = $h->endBuffer();
				return buildPath($elem, $path, ++$depth, $nodes);
			}
			
		}
	}
}

/*
//print_r($xml);
$buildPath = "";
$j = 0;
for ($i = 0; $i < count($GLOBALS['vals']); $i++) {
	$val = $GLOBALS['vals'][$i];
	if ($val['tag'] == "LINK" || ($val['tag'] == "LINKS" && $val['type'] == "complete")
			|| ($val['tag'] == "LINKS" && $val['type'] == "open")) {
		if ($val['level'] - 2 == $j && 
				preg_replace("/\//", "", $val['attributes']['HREF']) == $GLOBALS['script'][$j]) {
			//print($buildPath . "<br />");
			if ($j < count($GLOBALS['script']) - 1) {
				doLink($val, $buildPath);
				$buildPath .= $val['attributes']['HREF'];	
				print(" &gt;&gt; ");
			} else {
				print($val['attributes']['DISPLAY']);
			}	
			$j++;
		}
	}
}
*/
?>
