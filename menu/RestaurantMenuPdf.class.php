<?php
include_once("RestaurantMenu.class.php");

class RestaurantMenuPdf extends RestaurantMenu {


	function render() {
		global $h;
		echo 'here';
		$newCells = array(0, 3, 4, 5);
		//'width="100%"'
		//$h->otable();
		//$h->otd('valign="top"');
		$h->odiv('class="menu-row"');
		$h->odiv('class="menu-cell left"');
		foreach ($this->menu as $i => $menu) {
			$this->renderSection($menu);
			$h->br(2);
//			if ($this->returnToTop) $h->a('#top', "Return to Top", 'class="backtotop"');
			$index = array_search($i, $newCells);
/*
			if ($index > -1) {
				$this->newCell();
			}
*/
			if ($index > -1 && $index % 2 == 0) {
				$this->newCell();	
			} else if ($index > -1) {
				$this->newRow();
			}

		}
		$h->cdiv();
		$h->cdiv();
		//$h->ctd();
		//$h->ctable();
	}

/*
	function render() {
		global $h;

		$newCells = array(0, 3, 4, 5);
		$h->otable('width="100%"');
		$h->otd('valign="top"');

		foreach ($this->menus as $i => $menu) {
			$this->renderSection($menu);
//			$index = array_search($i, $newCells);
			if ($index > -1 && $index % 2 == 0) {
				$this->newCell();	
			} else if ($index > -1) {
				$this->newRow();
			} else {
				$h->br(2);
			}
		}
		$h->ctd();
		$h->ctable();

	}
*/	
	function newCell() {
		global $h;
		$h->cdiv();
		$h->odiv('class="menu-cell right"');
		//$h->ctd();
		//$h->otd('valign="top"');
	}
	
	function newRow() {
		global $h;
		$h->cdiv();
		$h->cdiv();
		$h->odiv('class="menu-row"');
		$h->odiv('class="menu-cell left"');
//		$h->ctd();
//		$h->corow();
//		$h->otd('valign="top"');
	}	


	function displayMenu($items) {
		global $h;
		global $webroot;
		$h->otable('width="100%" cellspacing="0" cellpadding="0"');
		for ($i = 0; $i < count($items); $i++) {
			$item = $items[$i];
			$name = $item['name'];
			$price = preg_replace("/;/", "<br />", $item['price']);
			$price = preg_replace("/:/", "&nbsp;", $price);
			if ($i > 0) $h->corow();
			$h->th($name, 'align="left" valign="bottom" width="50%"');
			$h->td($price, 'align="right" valign="bottom"');			
			$h->corow();
			$h->td($item['descr'], 'colspan="2"');
////ISSUE
//			$h->corow();
//			$h->td(' ', 'colspan="2"');
		}
		$h->ctable();
		
	}       	


	function displayDictionary($items) {
		global $h;
		$h->otable('width="100%" cellspacing="0" cellpadding="0"');
		for ($i = 0; $i < count($items); $i++) {
			if ($i > 0) $h->corow();
			$item = $items[$i];
			$h->td('<strong>'.$item['left'].':</strong>', 'align="left" valign="top"');
			$h->td($item['right'], 'align="right" valign="top"');
		}
		$h->ctable();
	}

	function displayGridMenu($items) {
		global $h;
		global $webroot;
		global $fileroot;
		$headers = array('', '8"', '10"', '14"', '16"');
		$h->otable('width="100%" class="menu-table"');
		for ($i = 0; $i < count($headers); $i++) {
			$h->th($headers[$i]);
		}
		for ($i = 0; $i < count($items); $i++) {
			
			$item = $items[$i];
			$h->cotr();
			$h->otd();
			$name = $item['name'];
			/*
			if (array_key_exists('img', $item)) {
				$src = '/img/'.$item['img'];
				$thumb = $fileroot.'/img/thumb/'.$item['img'];
				//$h->tnl();
				//$name = '<img src="'.$thumb.'" rel="'.$src.'" class="tooltip" ' .
					'width="50" alt="'.$item['name'].'" /> ' . $name;
				$h->tag('img', 'src="'.$thumb.'" width="50"');
			}
			*/
			//$h->img('/img/'.$thumb, '');
			$h->tnl('<strong>'.$name.'</strong>');
			
			if (array_key_exists("toppings", $item)) {
				$h->div($item['toppings']);
			}
			
			$h->ctd();
			for ($j = 0; $j < count($item['prices']); $j++) {
				$h->td(number_format($item['prices'][$j], 2));
			}
		}
		$h->ctable();
	}
	
	function display2ColCtr($items) {
		global $h;
		$h->otable('width="100%" cellspacing="0" cellpadding="0"');
		for ($i = 0; $i < count($items); $i++) {
			if ($i > 0) $h->corow();
			$h->th($items[$i]['left'], 'width="50%"');
			$h->th($items[$i]['right'], 'width="50%"');
		}
		$h->ctable();                          
	}	
	
	function display3Col($items) {
		global $h;
		
		$h->otable('width="99%" align="center" cellspacing="0" cellpadding="0"');
		for ($i = 0; $i < count($items); $i++) {
			$h->otd('width="33%" align="center" valign="top"');
		
			$h->tbr('<strong>'.$items[$i]['title'].'</strong>');
//ISSUE			$h->tnl('???');
			$h->tnl(substr($items[$i]['descr'], 0, 21));
			//$h->div($items[$i]['descr'], 'class="descr"');
		
			$h->ctd();
		}
		$h->ctable();                          
		
	}

}

?>
