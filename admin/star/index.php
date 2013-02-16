<?php
$local['jsModules']['textfill'] = true;
include("../../inc/application.php");

$h->scriptfile('../../js/star.jquery.js');
$h->scriptfile('star.js');
$datafile = $site['fileroot']."/star.json";

if (array_key_exists('s', $_POST)) {
	$data = array(
		'text'=>$_POST['input-canvas-text'],	
		'radius' => array(
			'outer'=>$_POST['input-canvas-outer-radius'],
			'inner'=>$_POST['input-canvas-inner-radius']
		),
		'numPoints'=>$_POST['input-canvas-numPoints'],
		'display'=>array_key_exists('input-canvas-display', $_POST)
	);
	$json = json_encode($data);
	file_put_contents($datafile, $json);		
}

$json = file_get_contents($datafile);
$data = json_decode($json, true);

//print_r($data);

?>


<style type="text/css">
.canvas-text {
	border: thin solid black;
}

#star {
	border: thin solid black;
}
</style>

<?php
$h->oform("");
$h->otable('width="100%"');
$h->otd('valign="top"');
$h->tbr("<strong>Text:</strong>");
$h->intext("input-canvas-text", $data['text']);
$h->br();
$h->tbr("<strong>Outer Radius:</strong>");
$h->intext("input-canvas-outer-radius", $data['radius']['outer']);
$h->br();
$h->tbr("<strong>Inner Radius:</strong>");
$h->intext("input-canvas-inner-radius", $data['radius']['inner']);
$h->br();
$h->tbr("<strong>Points:</strong>");
$h->intext("input-canvas-numPoints", $data['numPoints']);
$h->br();
$h->tnl("<strong>Display:</strong>");
$atts = ($data['display']) ? 'checked="checked"' : '';
$h->input('checkbox', "input-canvas-display", 1, $atts);
$h->br();
$h->input('submit', 's', "Save");
$h->cform();
$h->ctd();
$h->otd('valign="top"');
//$h->scriptfile('../js/jquery/jquery.js');


//$h->div('', 'id="star"');
//<canvas id="myCanvas" width="700" height="500" style="border: thin solid black;"></canvas>
$h->odiv('id="canvas-wrapper"');
$h->otag('canvas', 'id="star" style="border: thin solid black;"');
$h->ctag('canvas');
$h->odiv('class="canvas-text"');
$h->span($data['text']);
$h->cdiv();
$h->cdiv(); 
$h->ctd();
$h->ctable();
$template->footer();
?>
