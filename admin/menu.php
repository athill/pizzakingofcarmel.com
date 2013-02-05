<?php
include("../inc/application.php");
include($site['incroot'].'/uft/Formfield.class.php');
$f = new Formfield();


$data = json_decode(file_get_contents($site['fileroot'].'/menu/data.json'), true);

foreach ($data as $i => $area) {
	$h->h2($area['title']);
	foreach ($area['sections'] as $j=> $section) {
		$h->tbr($section['type']);
		switch ($section['type']) {
			case 'grid':

				break;
			case 'text':
				$ff = array(
					'name'=>$i.'_'.$j.'_text',
					'fieldtype'=>'textarea',
					'value'=>$section['content']
				);
				field($ff);

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


function field($ff) {
	global $h, $f;
	$ff = $f->setDefaults($ff);
	if ($ff['label'] != '') {
		$f->label($ff);
		$h->br();
	}
	$f->field($ff);
}


$template->footer();
?>