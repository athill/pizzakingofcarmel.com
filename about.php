<?php
include("inc/application.php");
$text = <<<EOT
We are proud to have served the peole of Carmel and Hamilton County 
since 1991. Affiliated with the Muncie branch of Pizza King, we offer 
the classic Pizza King fare along with time proven francise favorites.
EOT;
$h->tag('p', '', $text);
////features
$features = array(
	array( 'title'=>'OUR CRUST!', 'content'=>"Pizza King's best kept secret " .
				"and the success of every pizza we make .. Fresh and delicious." ),
	array( 'title'=>'OUR CHEESE!', 'content'=>"One of the most important ingredients " . 
				"is Pizza King's fresh provolone cheese for a richer taste " . 
				"and creamier Consistency you won't find in a mozzarella." ),
	array( 'title'=>'OUR TOPPINGS!', 'content'=>"Pizza King has a list of toppings to please " .
				"the taste of everyone... prepared in a style all our own... " .
				"our ingredients are diced and evenly distributed for more " . 
				"consistent flavor." ), 
	array( 'title'=>'OUR SQUARE PIECES!',  'content'=>"Why? .. Simple! It provides for easier Eating " .
			"and better division of the pizza... sized to fit." )
);
for ($i = 0; $i < count($features); $i++) {
	$feature = $features[$i];
	$h->odiv('class="feature"');
	$h->div($feature['title'], 'class="feature-title"');
	$h->div($feature['content'], 'class="feature-content"');
	$h->cdiv();
}

$text = <<<EOT
We are family owned and operated since 1991 with other family stores operating 
since the early 1970's.
EOT;
$h->tag('p', '', $text);

$text = <<<EOT
We hope you will try our high quality pizza and become one of our loyal 
Pizza King customers.
EOT;
$h->tag('p', '', $text);


$template->footer();
?>
