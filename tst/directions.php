<?php
include("inc/application.php");
$h->odiv('class="center-column"');
$h->img('/img/directions.png', 'Map of store area');
/*
$h->tag('embed', 'src="img/directions.svg" width="300" height="100" ' .
	'type="image/svg+xml" ' .
	'pluginspage="http://www.adobe.com/svg/viewer/install/"');
*/
//<embed src="rect.svg" width="300" height="100"
//type="image/svg+xml"
//pluginspage="http://www.adobe.com/svg/viewer/install/" /> 
$h->br();
$text = <<<EOT
Pizza King of Carmel is located in the Carmel Court Office Plaza:
EOT;
$h->tag('p', '', $text);
$text = <<<EOT
301 E. Carmel Dr., Suite A-800
EOT;
$h->tag('p', 'class="indent"', $text);
$text = <<<EOT
On the south side of Carmel Drive in between Keystone Parkway and Rangeline Road. 
We are in the same building as MacNamara Florist.
EOT;
$h->tag('p', '', $text);

$h->oform($filename."#directions", "get");
$h->tnl("<strong>Where are you?</strong>");
$value = (array_key_exists('start', $_GET)) ? $_GET['start'] : "";
$h->input("text", "start", $value);
$h->input("submit", "btn", "Get Directions");
$h->cform();
$h->cdiv();
if (array_key_exists('start', $_GET)) {
	$h->script('var start = "'.$_GET['start'].'";');
?>
	<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=false&amp;key=ABQIAAAAO2AMthgPIfzQY47xmCzQDBTmVMrqb1-5-xRDHHmsqmNZ3Z5JuBRBS2NFiJUb6lgr9bGrfDxrjKFraA" type="text/javascript"></script>
    <script type="text/javascript"> 
	$(window).load(function() {
		initialize();
	});
	
	$(window).unload(function() {
		GUnload();
	});

	// Create a directions object and register a map and DIV to hold the 
    // resulting computed directions

    var map;
    var directionsPanel;
    var directions;

    function initialize() {
      map = new GMap2(document.getElementById("map_canvas"));
      map.setCenter(new GLatLng(39.961687,-86.121609), 15);
      directionsPanel = document.getElementById("route");
      directions = new GDirections(map, directionsPanel);
      var route = "from: " + start + " to: 301 E Carmel Dr, Carmel, IN 46032";
      //alert(route);
      directions.load(route);
    }
    </script>


<?php
	$h->tag("a", 'name="directions"', "");
	$h->div('', 'id="map_canvas" style="width: 70%; height: 480px; float:left; border: 1px solid black;"');
	$h->div('', 'id="route"');
}
$template->footer();
?>
