<?php
include("inc/application.php");

/*
$text = <<<EOT
We offer our full menu for parties and meetings of any size
EOT;
$h->tag('p', '', $text);

$text = <<<EOT
Group sized bowls of salad and pasta, along with sandwich trays, 
are available for larger groups.
EOT;
$h->tag('p', '', $text);

$text = <<<EOT
Of course, our high quality pizza and breadsticks are available for any 
number of guests or coworkers.
EOT;
$h->tag('p', '', $text);

$text = <<<EOT
Cookie trays are also available for pre-orders only.
EOT;
$h->tag('p', '', $text);

$text = <<<EOT
We always look forward to delaing with each customer, insuring their catering 
needs are being met. We want each party, meeting, or event to be a "royal" 
hit with Pizza King of Carmel. 
EOT;
$h->tag('p', '', $text);
*/
$items = array(
	"We can feed your group for as little as $4.00 per person.",
	"Groups of any size; 50 or more people please call at least <strong>" .
		"24 hours</strong> ahead.",
	"***FREE DELIVERY*** available within limited area.",
	"Plates, cups, and napkins available upon request.",
	"10% discount for orders over $150.00 before tax."
);

$options = array(
	array('label'=>"PIZZA", 'text'=>"16 inch pizzas feed aprx. 5-6 people " . 
			"(count on 6 if including salad or breadsticks)  Prices and " .
			"varieties are the same as listed on our regular menu."),
	array('label'=>"BREADSTICKS", 'text'=>"$4.25: 5 sticks per order.  " .
			"We include plenty of extra nacho cheese and marinara " .
			"for dipping, based on number of people."),
	array('label'=>"SALAD BOWL", 'text'=>"$35.00 Feeds aprx. 15 people. " .
			"Our own fleshly chopped mixture of lettuce, carrots, and red " .
			"cabbage.  Assortment of dressings included."),
	array('label'=>"PASTA BOWL", 'text'=>"$30.00  Enough for 10-15 people. " .
			"Delicious Baked Spaghetti topped with our pizza cheese."),
	array('label'=>"SANDWICH TRAY", 'text'=>"$35.00  Feeds aprx. 8 people. " .
			"Includes four hot, 11 inch sandwiches cut into pieces. Beef " .
			"Boat, Submarine, Original Stromboli, and BBQ Stromboli."),
	array('label'=>"COOKIE TRAY", 'text'=>"$25.00 aprx. 3 dozen cookies. " .
			"<strong>Must order 24 hours in advance.</strong>  Chocolate " .
			"chunk, white chocolate macadamia, and oatmeal raisin, " . 
			"everyone's favorites."),
	array('label'=>"DRINKS", 'text'=>"We offer prechilled 2 liters of Pepsi " .
			"products:  Pepsi, Diet Pepsi, Mt. Dew, and Sierra Mist."),
	array('label'=>"ICE", 'text'=>"Bags of ice  available only with " .
		"<strong>24 hour advanced ordering.</strong>")
);

/////Display
$h->liArray("ul", $items);
for ($i = 0; $i < count($options); $i++) {
	$opt = $options[$i];
	$h->odiv('class="catering-section"');
	$h->span($opt['label'] . " - ", 'class="catering-label"');
	$h->tnl($opt['text']);
	$h->cdiv();
}

$template->footer();
?>
