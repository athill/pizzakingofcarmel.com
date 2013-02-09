<?php
include("inc/application.php");

$h->odiv('id="pk-delivery"');
$h->img('/img/delivery.png', 'Delivery Area');
$h->tbr("*We offer <u>Free Delivery</u>* with a $10 minimum food purchase.");
$h->tbr("Call to Order: 317-848-7994");
$items = array("No checks", "We accept all credit/debit cards for delivery", 
    "Delivery orders should be placed no later than a half an hour before closing");
$h->liArray("ul", $items);
$h->cdiv();

?>
<!--
<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=false&amp;key=ABQIAAAAO2AMthgPIfzQY47xmCzQDBTc-SnnGXkKTHhKG3VH2OQgm_p4BhRw9mOnDYIYV1rPs62yBm04o8LoOw" type="text/javascript"></script>
    <script type="text/javascript">

	$(window).load(function() {
		initialize();
	});
	
	$(window).unload(function() {
		GUnload();
	});
    function initialize() {
      if (GBrowserIsCompatible()) {
        var map = new GMap2(document.getElementById("map_canvas"));
        ////center(glatLang, int zoom);
        map.setCenter(new GLatLng(39.971792,-86.121609), 12);
        ////pk: 39.961687,-86.121609
        ///ditch:  39.90541,-86.183922
	    var point = new GLatLng(39.961687,-86.121609);
	    map.addOverlay(new GMarker(point));
 		var marker = new GMarker(point);
 		GEvent.addListener(marker, "click", function() {
 			//alert("here");
    		marker.openInfoWindowHtml("Pizza King of Carmel<br />301 E. Carmel Dr., Suite A-800<br />" +
				"Carmel, IN 46032<br /><br /><b>" + point + "</b>");
  		});
  		map.addOverlay(marker);
        
        map.setUIToDefault();
      }
    }

    </script>

	<div id="map_canvas" style="width: 500px; height: 400px"></div>
-->

<?php
//$h->div('', 'style="clear: all;"');
$template->footer();
?>
