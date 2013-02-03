<?php
include("../inc/application.php");

$data = json_decode(file_get_contents($GLOBALS['fileroot'].'/menu/data.json'), true);

foreach ($data as $i => $area) {
	$h->h2($area['title']);
	foreach ($area['sections'] as $j=> $section) {
		$h->tbr($section['type']);
		switch ($sections['type']) {
			case 'grid':

				break;
			case 'text':

				break;
			case 'menu':

				break;
			case 'dict':

				break;
			case '2-col-center';

				break;
			case '3-col':

				break;
		}
	}
}

$h->pa($data);


$template->footer();
?>