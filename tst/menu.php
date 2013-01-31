<?php
include("inc/application.php");

////////Initiate the tooltip
$js = <<<TEXT
$(function() {
	$('.tooltip').tooltip({ 
	    delay: 0, 
	    showURL: false, 
	    bodyHandler: function() { 
	        return $("<img/>").attr("src", this.src); 
	    } 
	});
});
TEXT;
$h->script($js);

////////////////////////
//////// Initialize the data
/////////////////////////////

////Appetizers
$appetizers = array(
	'id'=>"apps",
	'title' => "Appetizers",
	'sections'=>array(
		array('type'=>'menu', 
			'items' => array(
				array( 'name'=>'Nacho Chips', 'descr'=>'Corn tortilla chips served with ' . 
					'nacho cheese', 'price'=>"3.75" ),
				array( 'name'=>'Nacho Chips Deluxe', 'descr'=>"Corn tortilla chips covered " . 
					"with taco meat, nacho cheese, sour cream, and tomatoes", 
					'price'=>"Large:6.50;Small:5.50",
					'img'=>'IMG_4613.jpg'),
				array( 'name'=>'Chicken Wings', 'descr'=>"BBQ or Hot chicken wings baked and " . 
					"served with ranch dressing and celery", 
					'price'=>"6 for:5.25;12 for:10.00",
					'img'=>'IMG_4554.jpg' ),
				array( 'name'=>'Breadsticks', 'descr'=>'Five garlic buttered breadsticks ' . 
					'served with nacho cheese', 'price'=>"4.75" ),
				array( 'name'=>'Cheese Bread', 'descr'=>"Three slices of our Texas Toast " . 
					"style garlic bread baked with pizza cheese and served with " . 
					"Italian sauce", 'price'=>"5.00" ),
				array( 'name'=>'Pizza Bread', 'descr'=>"Three slices of our Texas Toast " . 
					"style garlic bread baked with pizza cheese and your choice " . 
					"of one pizza topping", 'price'=>"5.75" ),
				array( 'name'=>'Potato Chips', 'descr'=>"Additional cups of nacho cheese " . 
					"<strong>or</strong> Italian sauce ............ " . 
					"1.00", 'price'=>"1.50" )
			)
		),
		array('type'=>'text',
			'content'=>'<div style="text-align: center;">Additional cups of nacho ' .
				'cheese<br />or Italian sauce ............ 1.00</div>'
		)
	)
);

////pizzas
$pizzas = array(
	'id'=>"pizzas",
	'title' => "Pizzas",
	'sections'=>array(
		array('type'=>"grid",
			'items'=>array(
				array( 'name'=>"Royal Feast", 'toppings'=>"Pepperoni, Mushrooms, Onion, " .
					"Green Peppers, Sausage", 'prices'=>array(7.2,10.2,18.3,22.35)),
				array( 'name'=>"Grilled Chicken Ranch", 'toppings'=>"Garlic sauce, Ranch, " .
					"Onion, Bacon, Chicken, Tormatoes, Cheddar Cheese, and Provolone", 
			 		'prices'=>array(7.95,11.35,19.8,24.35)),
				array( 'name'=>"Meat Feast", 'toppings'=>"Pepperoni. Sausage, Baked Ham, " .
					"Bacon, Hamburger", 'prices'=>array(8.95,12.55,21.95,25.65)),
				array( 'name'=>"Veggie", 'toppings'=>"Mushrooms, Onion, " .
					"Green Peppers, Tomatoes, Black Olives", 'prices'=>array(7.2,10.2,18.3,22.35)),
				array( 'name'=>"Cowboy", 'toppings'=>"Double Pepperoni, Double Mushrooms, " .
					"Double Sausage, Double Cheese",'prices'=>array(8.95,12.55,21.95,25.65),
					'img'=>'IMG_4548.jpg'),
				array( 'name'=>"Taco", 'toppings'=>"Refried Beans, Taco Meat, Lettuce, " .
					"Tomatoes", 'prices'=>array(7.2,10.2,18.3,22.35),
					'img'=>'IMG_4629.jpg'),
				array( 'name'=>"BLT", 'toppings'=>"Bacon, Mayonaise, Lettuce, Tormato", 		'prices'=>array(7.2,10.2,18.3,22.35)),
				array( 'name'=>"Cheese", 'prices'=>array(4.95,6.75,12.8,15.95)),
				array( 'name'=>"One Item", 'prices'=>array(5.7,7.8,14.6,18.1)),
				array( 'name'=>"Two Items", 'prices'=>array(6.45,8.98,16.4,20.25)),
				array( 'name'=>"Additional Item", 'prices'=>array(0.75,1.15,1.8,2.15)),
				array( 'name'=>"Extra Cheese",  'prices'=>array(1.25,1.55,2.5,2.8)),
				array( 'name'=>"Barbecue",  'prices'=>array(0.4,0.6,1.0,1.5)),
				array( 'name'=>"Sour Cream (on pizza)", 'prices'=>array(0.6,0.95,1.9,2.3))
			)
		),	
		array('type'=>'text', 
			'content'=>'<strong>Pan Pizza Available in 10" and 14" add $1.00 or $2.00' . 
				'</strong><br /><br /><div style="text-align: center;">' .
				'Pepperoni, Sausage, Baked Ham, Bacon, Hamburger, Chicken, ' . 
				'Anchovies, Mushrooms, Black O1ives , Onions, Green Peppers, ' .
				'Tomatoes, Banana Peppers, Jalapeno Peppers, and Pineapple' .	
				'</div>'
		)
	)
);

/////Mexican
$mexican = array(
	'id'=>"mex",
	'title' => "Mexican Food",
	'sections'=>array(
		array('type'=>'menu', 
			'items' => array(
				array( 'name'=>'Tacos (Hard or Soft Shell)', 
					'descr'=>'Flour or com tortilla filled with beef, cheese, ' . 
						'lettuce, and sauce', 
					'price'=>"1.75<br />3 for $5.00 ", 
					'img'=>'IMG_4601.jpg'),
				array( 'name'=>'Burritos (Beef and Bean Only)', 
					'descr'=>' Soft flour tortilla made to your specifications ' . 
						'with shredded cheddar cheese, lettuce, and sauce', 
					'price'=>"4.50" ),
				array( 'name'=>'Mexican Plate', 
					'descr'=>'Beef burrito, hard shell taco, lettuce, tomatoes, sour ' . 
						'cream, and beans all on the side', 
					'price'=>"6.50" ),
				array( 'name'=>'Taco Salad', 
					'descr'=>'Bed of ,lettuce surrounded with crispy tortilla chips ' . 
						'and topped with beef, cheese, tomatoes, and sauce', 
					'price'=>"Small 5.75<br />Large 6.50",
					'img'=>'IMG_4587.jpg')						
			),
		),
		array('type'=>'text',
			'content'=>'Tomatoes or Sour Cream:<br />Add $1.00 for ' . 
				'every burrito or 3 tacos'
		)
	)
);


/////Pasta
$pasta = array(
	'id'=>"pasta",
	'title' => "Pasta",
	'sections'=>array(
		array('type'=>'menu',
			'items' => array(
				array( 'name'=>'Large Baked Spaghetti', 
					'descr'=>'A large order of spaghetti with meat sauce topped ' . 
						'with pizza cheese then baked to perfection. Indudes a ' . 
						'garden salad with two slices of garlic bread', 
					'price'=>"8.00" ),
				array( 'name'=>'Small Baked Spaghetti', 
					'descr'=>'A half of order of spaghetti with meat sauce topped ' .
						'with pizza cheese then baked to perfection. Also includes ' . 
						'one slice of garlic bread', 
					'price'=>"5.25" ),
				array( 'name'=>'Large Spaghetti', 
					'descr'=>'A large order of spaghetti with meat sauce. Also ' . 
						'includes a garden salad and two slices of garlic bread', 
					'price'=>"7.00" ),
				array( 'name'=>'Small Spaghetti', 
					'descr'=>'  A half of order of spaghetti with meat sauce served ' . 
						'with one slice of garlic bread', 
					'price'=>"4.75" )			
			)
		)
	)
);


/////Salads
$salads = array(
	'id'=>"salads",
	'title' => "Salads",
	'sections'=>array(
		array('type'=>'menu',
			'items' => array(
				array( 'name'=>'Garden Salad', 
					'descr'=>"Tossed salad that's perfect with pizza or with a sandwich", 
					'price'=>"2.50" ),
				array( 'name'=>'Junior Chef Salad', 
					'descr'=>'A smaller version of the large chef salad without egg', 
					'price'=>"5.50" ),
				array( 'name'=>'Large Chef Salad', 
					'descr'=>'Our tossed salad greens topped with pizza cheese, ' . 
						'egg, and your choice of ham or chicken', 
					'price'=>"6.50" ),			
			)
		),
		array('type'=>'dict',
			'items'=>array(
				array('left'=>'Dressing', 
					'right'=>'Ranch, Fat Free Ranch, French, Fat Free ' . 
						'French, 1000 Island, Roquefort, Italian, and Poppy ' .
						'Seed'
				)
			)
		),
		array('type'=>'2-col-center',
			'items'=>array(
				array('left'=>'Extra Dressing 1.00', 
					'right'=>'Add Egg 1.00'
				)
			)
		)
	)
);



////Beverages
$beverages = array(
	'id'=>"beverages",
	'title' => "Beverages",
	'sections'=>array(
		array('type'=>'dict',
			'items' => array(
				array( 'left'=>'Soft Drinks', 
					'right'=>"Pepsi, Diet Pepsi, Mt. Dew, Sierra Mist, Fruit Punch, and Orange"
				)
			)
		),
		array('type'=>'2-col-center',
			'items'=>array(
				array('left'=>'Small 1.75', 
					'right'=>'Large 2.25'
				)
			)
		), 
		array( 'type'=>'dict',
			'items'=>array(
				array('left'=>'2 Liters',
				 'right'=>'Pepsi, Diet Pepsi, Mt. Dew, Sierra Mist'
				)
			)
		)		
	)
);


////Sandwiches
$sandwiches = array(
	'id'=>"sandwiches",
	'title' => "Hot Sandwiches",
	'sections' => array(
		array('type'=>'3-col', 
			'items'=>array(
				array('title'=>'Submarine', 'descr'=>'Ham, salami, and ' .
						'luncheon loaf layered with provolone<br />' .
						'Cheese, onions, and tomato sauce'),
				array('title'=>'Beef Boat', 'descr'=>'Shaved roast beef ' . 
					'smothered In brown gravy and provolone ' . 
					'cheese, served piping hot'),
				array('title'=>'Strombloli', 'descr'=>'Our sausage, onions, ' . 
					'provolone cheese and your choice of sauce (BBQ, Brown ' . 
					'Gravy, Italian, Tomato)')
			)
		
		),
		array('type'=>'2-col-center',
			'items'=>array(
				array('left'=>'Whole Sandwich &mdash; 8.50', 
					'right'=>'Half Sandwich &mdash; 4.50'
				)
			)
		),
		array('type'=>'menu',
			'items' => array(
				array( 'name'=>'Baked Ham', 
					'descr'=>'Shaved ham piled on a 6" toasted bun', 
					'price'=>"5.25" 
				),
				array( 'name'=>'Junior Chef Salad', 
					'descr'=>'Shaved lean roast beef served on a 6" toasted bun', 
					'price'=>"5.25" 
				)
			)
		),
		array('type'=>'text',
			'content'=>'<strong>Extra Meat, Cheese, Or Veggie:  ' . 
				'Whole 2.00 Each Half 1.00</strong>'
		),
		array('type'=>'text',
			'content'=>'<strong>Deluxe (mayo, lettuce, tomato) &mdash; 1.00</strong>'
		)		
	)
);

///////// Sequence of menu array to display
$menus = array(
	$pizzas,
	$appetizers,
	$mexican,
	$pasta,
	$salads,
	$beverages,
	$sandwiches
);

//////////////////
///// Start Display
/////////////////////


$h->odiv();
$h->odiv('style="margin: 0 auto; width: 40em;"');

////Download
$h->odiv('style="text-align: right"');
$h->startBuffer();
$h->tnl("Download");
//$h->img($webroot."/img/icons/pdficon_large.gif", "");
$h->a("/img/menu.pdf", $h->endBuffer());
$h->cdiv(); ////Close download

////Menu of menus
$items = array();
for ($i = 0; $i < count($menus); $i++) {
	$menu = $menus[$i];
	$h->startBuffer();
	$h->a('#'.$menu['id'], $menu['title']);
	$items[] = $h->endBuffer();
}
$h->liArray("ul", $items);

////Display menus
for ($i = 0; $i < count($menus); $i++) {
	$menu = $menus[$i];
	////Start menu div
	$h->odiv('class="menu-section" id="'. $menu['id'] .'"');
	$h->div($menu['title'], 'class="menu-section-title"');		
	$h->tag("a", 'name="'.$menu['id'].'"', '', false);
	////delegate menu display
	for ($j = 0; $j < count($menu['sections']); $j++) {
		$section = $menu['sections'][$j];
		////Delegate menu section type
		switch ($section['type']) {
			case "grid":
				displayGridMenu($section['items']);		
				break;
			case "menu":
				displayMenu($section['items']);		
				break;
			case "dict":
				displayDictionary($section['items']);
				break;
			case "2-col-center":
				display2ColCtr($section['items']);
				break;
			case "3-col":
				display3Col($section['items']);
				break;				
			case "text":
			default:
				$h->tnl($section['content']);
				break;
		}
	}
	$h->br(2);
	$h->a('#top', "Return to Top", 'class="backtotop"');
	////Close menu div
	$h->cdiv();	//close menu-section	
}
$h->cdiv();  ////close content div
$h->cdiv(); ////close wrapper div -- necessary?


////////////////////
//////// Functions
//////////////////////
function displayDictionary($items) {
	global $h;
	$h->otag('dl', 'class="pk-menu-dict"');
	for ($i = 0; $i < count($items); $i++) {
		$item = $items[$i];
		$h->tag('dt', '', $item['left'].':');
		$h->tag('dd', '', $item['right']);
	}
	$h->ctag('dl');
}

function displayGridMenu($items) {
	global $h;
	global $webroot;
	$headers = array('', '8"', '10"', '14"', '16"');
	$h->otable('class="menu-table"');
	for ($i = 0; $i < count($headers); $i++) {
		$h->th($headers[$i]);
	}
	for ($i = 0; $i < count($items); $i++) {
		$item = $items[$i];
		$h->cotr();
		$h->otd();
		$name = $item['name'];
		if (array_key_exists('img', $item)) {
			$src = $webroot.'/img/'.$item['img'];
			$thumb = $webroot.'/img/thumb/'.$item['img'];
			$name = '<img src="'.$thumb.'" rel="'.$src.'" class="tooltip" ' .
				'width="50" alt="'.$item['name'].'" /> ' . $name;
		}
		$h->div($name, 'class="menu-item-name"');
		if (array_key_exists("toppings", $item)) {
			$h->div($item['toppings'], 'class="menu-item-descr"');
		}
		$h->ctd();
		for ($j = 0; $j < count($item['prices']); $j++) {
			$h->td(number_format($item['prices'][$j], 2));
		}
	}
	$h->ctable();
}

                             



function displayMenu($items) {
	global $h;
	global $webroot;
	for ($i = 0; $i < count($items); $i++) {
		$item = $items[$i];
		$h->odiv('class="menu-item"');
		$h->odiv('class="menu-item-name-price-row"');
		$name = $item['name'];
		if (array_key_exists('img', $item)) {
			$src = $webroot.'/img/'.$item['img'];
			$thumb = $webroot.'/img/thumb/'.$item['img'];
			$name = '<img src="'.$thumb.'" rel="'.$src.'" class="tooltip" ' .
				'width="50" alt="'.$item['name'].'" /> ' . $name;
		}		
		$h->div($name, 'class="menu-item-name left"');
		$price = preg_replace("/;/", "<br />", $item['price']);
		$price = preg_replace("/:/", "&nbsp;", $price);
		$h->div($price, 'class="menu-item-price right"');
		$h->cdiv();
		$h->div($item['descr'], 'class="menu-item-descr"');
		$h->cdiv();
	}
}                                                
          
function display2ColCtr($items) {
    global $h;
    $h->odiv('class="pk-menu-2-col-center"');
    for ($i = 0; $i < count($items); $i++) {
    	$h->odiv('class="row"');
    	$h->div($items[$i]['left'], 'class="column"');
    	$h->div($items[$i]['right'], 'class="column"');
    	$h->cdiv();
    }
    $h->cdiv();                          
}
              
function display3Col($items) {
    global $h;
    $h->odiv('class="pk-menu-3-col"');
    for ($i = 0; $i < count($items); $i++) {
    	$h->odiv('class="column"');
    	$h->div($items[$i]['title'], 'class="title"');
    	$h->div($items[$i]['descr'], 'class="descr"');
    	$h->cdiv();
    }
    $h->cdiv();                          
}          
                            
$template->footer();
?>
