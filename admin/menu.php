<?php
$local['stylesheets'] = array('/menu/menu.css');
include("../inc/application.php");
include($site['incroot'].'/uft/Formfield.class.php');
$f = new Formfield();


$data = json_decode(file_get_contents($site['fileroot'].'/menu/data.json'), true);
// $h->pa($data);
$h->odiv('id="menu-container"');
foreach ($data as $i => $area) {
	$h->odiv('class="menu-section" id="'.$area['id'].'"');
	$h->div($area['title'], 'class="menu-section-title"');
	$h->tag('a', 'name="'.$area['id'].'"', ''. true, false);
	foreach ($area['sections'] as $j=> $section) {
		$h->tbr($section['type']);
		// $h->pa($section);
		$basename = $section['type'].'_'.$i.'_'.$j;
		switch ($section['type']) {
			case 'grid':
				$headers = array('', '8"', '10"', '14"', '16"');
				$h->otable('class="menu-table"');
				for ($i = 0; $i < count($headers); $i++) {
					$h->th($headers[$i]);
				}
				for ($i = 0; $i < count($items); $i++) {
					
					$item = $items[$i];
					$h->cotr();
					$h->otd();
					$name = $item['name'];
					
					if (array_key_exists('img', $item)) {
						$src = $webroot.'/img/'.$item['img'];
						$thumb = $webroot.'/img/thumb/'.$item['img'];
						$name = '<img src="'.$thumb.'" rel="'.$src.'" class="tooltip" ' .
							'width="50" alt="'.$item['name'].'" /> ' . $name;
					}
					
					$h->div($name, 'class="menu-item-name"');			
					if (array_key_exists("toppings", $item)) {
						$h->div($item['toppings'], 'class="menu-item-descr"');
					}			
					$h->ctd();
					for ($j = 0; $j < count($item['prices']); $j++) {
						$h->td(number_format($item['prices'][$j], 2));
					}
				}
				$h->ctable();
				break;
			case 'text':
				$ff = array(
					'name'=>$basename,
					'fieldtype'=>'textarea',
					'value'=>$section['content']
				);
				fieldset($ff);
				$h->br();
				break;
			case 'menu':
				////name,descr,price,(img)
				foreach ($section['items'] as $k => $item) {
					$h->odiv('class="menu-item"');
					$h->odiv('class="menu-item-name-price-row"');
					////Name
					$h->odiv('class="menu-item-name left"');
					$h->intext($basename.'_'.$k.'_name', $item['name']);
					$h->cdiv('.menu-item-name');
					////Price
					$h->odiv('class="menu-item-price right"');
					$h->intext($basename.'_'.$k.'_price', $item['price']);
					$h->cdiv('.menu-item-price right');
					$h->cdiv('.menu-item-name-price-row');
					$h->odiv('class="menu-item-descr"');
					$h->intext($basename.'_'.$k.'_descr', $item['descr']);
					$h->cdiv('.menu-item-descr');
					$h->cdiv('.menu-item');
				}
				break;
			// TODO: change left-right to, um, term-definition
			case 'dict':
				foreach ($section['items'] as $k => $item) {
					$h->odiv('class="menu-item"');
					$h->odl();
					////term aka left
					$h->odt();
					$h->intext($basename.'_'.$k.'_left', $item['left']);
					$h->cdt();
					////definition aka right
					$h->odd();
					$h->intext($basename.'_'.$k.'_right', $item['right']);
					$h->cdd();					
					$h->cdl();
					$h->cdiv('.menu-item');
				}
				break;
			// TODO: Break into x-col/alignment (e.g., center)
			case '2-col-center';
				foreach ($section['items'] as $k => $item) {
					$h->odiv('class="menu-item"');
					$h->odiv('class="pk-menu-2-col-center"');
					$h->odiv('class="row"');
					////left
					$h->odiv('class="column"');
					$h->intext($basename.'_'.$k.'_left', $item['left']);
					$h->cdiv('.column');
					////right
					$h->odiv('class="column"');
					$h->intext($basename.'_'.$k.'_right', $item['right']);
					$h->cdiv('.column');
					$h->cdiv('.row');
					$h->cdiv('.pk-menu-2-col-center');
					$h->cdiv('.menu-item');
				}
				break;
			case '3-col':
				$h->odiv('class="menu-item"');
				$h->odiv('class="pk-menu-3-col"');
				foreach ($section['items'] as $k => $item) {
					////column
					$h->odiv('class="column"');
					$h->intext($basename.'_'.$k.'_title', $item['title']);
					$h->intext($basename.'_'.$k.'_descr', $item['descr']);
					$h->cdiv('.column');
				}
				$h->cdiv('pk-menu-3-col');
				$h->cdiv('.menu-item');
				break;
		}
	}
	$h->cdiv('#'.$area['id']);
}
$h->cdiv('#menu-container');

// TODO: something like this?
// function divset()


// TODO: something like this?
// function classdiv($name, $class, $value, $prefix='')


function fieldset($ff) {
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