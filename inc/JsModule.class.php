<?php
class JsModule {
	var $modules;
	
	function __construct() {
		$this->modules = array(
					////Tooltip
			// "tooltip" => array( 
			// 	"scripts" => array("/js/jquery/jquery.bgiframe.js",
			// 					"/js/jquery/jquery.dimensions.js",
			// 					"/js/jquery-tooltip/jquery.tooltip.js"),
			// 	"styles" => array("/js/jquery-tooltip/jquery.tooltip.css")
			// ),
			// ////Tree Table
			// "treeTable" => array( 
			// 	"scripts" => array("/js/treeTable/src/javascripts/jquery.treeTable.min.js"),
			// 	"styles" => array("/js/treeTable/src/stylesheets/jquery.treeTable.css")
			// ),
			// ////High Charts
			// "highcharts" => array(
			// 	"scripts" => array("/js/Highcharts-2.1.6/js/highcharts.js"),
			// 	"styles" => array("")
			// ),
			////superfish
			"popup" => array(
				"scripts" => array("/js/superfish/js/superfish.js",
								"/js/superfish/js/hoverIntent.js",
								"/js/superfish/js/jquery.bgiframe.min.js"),
				"styles" => array("/js/superfish/css/superfish.css", "/js/superfish/css/superfish-vertical.css")
			),
			// ////Galleria
			// "galleria" => array(
			// 	"scripts" => array("/js/galleria/galleria-1.2.5.min.js",
			// 					"/js/galleria/themes/classic/galleria.classic.min.js"),
			// 	"styles" => array()
			// ),
			// ////Tree Menu
			// "treemenu" => array(
			// 	"scripts" => array("/js/jquery.treeview/jquery.treeview.js",
			// 						"/js/jquery.treeview/lib/jquery.cookie.js"
			// 	),
			// 	"styles" => array("/js/jquery.treeview/jquery.treeview.css")
			// ),
			////textfill
			"textfill" => array( 
				"scripts" => array("/js/jquery/jquery-textfill.js"),
				"styles" => array()
			),
			///jquery-ui
			"jquery-ui" => array(
				"scripts" => array("/js/jquery/jquery-ui/js/jquery-ui-1.8.11.custom.min.js"),
				"styles" => array("/js/jquery/jquery-ui/css/ui-darkness/jquery-ui-1.8.11.custom.css")
			),
			////lightbox
			"lightbox" => array( 
				"scripts" => array(
					"/js/jquery/lightbox/js/lightbox.js"
				),
				"styles" => array(
					"/js/jquery/lightbox/css/lightbox.css"
				)
			),
		);
	}
	

}
?>
