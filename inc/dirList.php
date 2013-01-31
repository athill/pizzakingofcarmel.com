<?php
/*
print("<pre>");
print_r($vals);
print("<pre>");
*/
$in_dir == false;
$j = 0;

for ($i = 0; $i < count($vals); $i++) {
	$val = $vals[$i];
	if (!$in_dir && $val['tag'] == "LINKS" && $val['type'] == "open" && $val['level'] - 2 == $j && 
			preg_replace("/\//", "", $val['attributes']['HREF']) == $script[$j]) {		
		if ($j == count($script) - 1) {
			$in_dir = true;
			print("<ul>\n");
		} else {
			$j++;
		}
	} else if ($in_dir && $val['tag'] == "LINKS" && $val['type'] == "close" && $val['level'] - 2 == $j) {		
		$in_dir = false;
		print("</ul>\n");
		
		break;
	} else if ($in_dir && ($val['type'] == "open" || $val['type'] == "complete") &&
			$val['level'] - 3 == $j) {
		print("<li>");
	//	print($val['level'] - 3	 == $j);
		doLink($val, $view);
		print("</li>\n");
	}
}
?>