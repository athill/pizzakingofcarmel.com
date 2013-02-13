<?php
$local['jsModules']['lightbox'] = true;
include("inc/application.php");
$pictures = array(
//	"coupon"=>array('src'=>"4363", 'comment'=>'coupon'),
//	"magnet"=>array('src'=>"4371", 'comment'=>'magnet'),
//	"giftcert"=>array('src'=>"4382", 'comment'=>'gift cert'),
//	"box"=>array('src'=>"4390", 'comment'=>'pizza box'),
	"box2"=>array('src'=>"4404", 'comment'=>'Pizza Box'),
	"cowboy"=>array('src'=>"4548", 'comment'=>'The Cowboy Pizza'),
//	"wings"=>array('src'=>"4563", 'comment'=>'Buffalo Wings'),
	"wings2"=>array('src'=>"4554", 'comment'=>'Buffalo Wings'),
	"strom"=>array('src'=>"4578", 'comment'=>'Stromboli'),
	"tacosalad"=>array('src'=>"4587", 'comment'=>'Taco Salad'),
	"tacos"=>array('src'=>"4601", 'comment'=>'Tacos'),
	"nachodeluxe"=>array('src'=>"4613", 'comment'=>'Nacho Deluxe'),
	"tacopizza"=>array('src'=>"4629", 'comment'=>'Taco Pizza')
);

//exit(0);
foreach  ($pictures as $p=>$picture) {
	//$h->tbr($picture['src']);
	$pictures[$p]['src'] = 'IMG_'.$pictures[$p]['src'].'.jpg';
	//$h->tbr($picture);
}

$pictures["pumpkin"] = array('src'=>"HPIM0400.JPG", 'comment'=>'Halloween');

$pictures["grace1"] = array('src'=>'grace04.jpg', 'comment'=>'Pizza Princess 1');
$pictures["grace2"] = array('src'=>'grace11.jpg', 'comment'=>'Pizza Princess 2');

$picture_order = array(
	"box2",
	"pumpkin",
	"grace1",
	"grace2",
	"cowboy",
	"nachodeluxe",
	"strom",
	"tacos",
	"tacosalad",
	"tacopizza",
	"wings2"
);

//print_r($pictures);
//$h->odiv('style="clear: both;"');
for  ($i = 0; $i < count($picture_order); $i++) { 
	$picture = $pictures[$picture_order[$i]];
	$h->odiv('class="pics-thumbs"');
	$h->startBuffer();
	$h->img('/img/thumb/'.$picture['src'], $picture['comment']);
	$img = trim($h->endBuffer());
	$h->a('/img/'.$picture['src'], $img, 'rel="lightbox[pictures]" title="'.$picture['comment'].'"');
	$h->div($picture['comment'], 'class="pics-comment"');
	$h->cdiv();
}
//$h->cdiv();



//$h->script("$(function() { $('a[rel*=lightbox]').lightBox(); });");
$template->footer();
?>
