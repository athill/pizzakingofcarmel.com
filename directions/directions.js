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