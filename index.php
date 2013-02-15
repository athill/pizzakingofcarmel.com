<?php
$local['jsModules']['textfill'] = true;
include("inc/application.php");

$h->scriptfile('/js/star.jquery.js');
$datafile = $site['fileroot']."/data.json";
$json = file_get_contents($datafile);
$data = json_decode($json, true);
if ($data['display']) {
$h->script("
$(function() {
	var opts = $json;
	var options = {
		numPoints: parseInt(opts.numPoints),
		radius: {
			outer: parseInt(opts.radius.outer),
			inner: parseInt(opts.radius.inner)
		}
	};
	$('#star').star(options);
	$('#canvas-wrapper .canvas-text').textfill({ maxFontPixels: 100 });
});");
}

$h->br();
$h->odiv('style="text-align: center;"');
if ($data['display']) {
	$h->odiv('style="float: right"');
	$h->odiv('id="canvas-wrapper"');
	$h->otag('canvas', 'id="star"');
	$h->ctag('canvas');
	$h->odiv('class="canvas-text"');
	$h->span($data['text']);
	$h->cdiv('close canvas-text');
	$h->cdiv('close canvas-wrapper');
	$h->cdiv('close float: right');
}
$h->img("/img/logo_from_sack.png", "", 'align="center"');
$h->cdiv('close text-align: center');
$h->br(2);

$template->footer();

?>


