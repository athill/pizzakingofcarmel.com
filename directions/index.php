<?php
$local = array(
	'stylesheets'=>array('directions.css')
);
include("../inc/application.php");
$h->odiv('class="center-column"');
//// map
$h->img('/img/directions.png', 'Map of store area', 'id="directions-map"');
$h->br();
//// verbiage
$h->p('Pizza King of Carmel is located in the Carmel Court Office Plaza:');

$h->p('301 E. Carmel Dr., Suite A-800', 'class="indent"');

$h->p('On the south side of Carmel Drive in between Keystone Parkway and Rangeline Road. 
	We are in the same building as MacNamara Florist.');

//// directions form
$h->oform($site['filename']."#directions", "get");
$h->tnl("<strong>Where are you?</strong>");
$value = (array_key_exists('start', $_GET)) ? $_GET['start'] : "";
$h->input("text", "start", $value);
$h->input("submit", "btn", "Get Directions");
$h->cform();

$h->cdiv('/.center-column');

//// directions
if (array_key_exists('start', $_GET)) {
	$h->script('var start = "'.$_GET['start'].'";');

	$h->scriptfile(array(
		'http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=false&amp;'.
			'key=ABQIAAAAO2AMthgPIfzQY47xmCzQDBTmVMrqb1-5-xRDHHmsqmNZ3Z5JuBRBS2NFiJUb6lgr9bGrfDxrjKFraA',
		'directions.js'
	));
	$h->tag("a", 'name="directions"', "", true, false);
	$h->div('', 'id="map_canvas"');
	$h->div('', 'id="route"');
}
$template->footer();
?>
