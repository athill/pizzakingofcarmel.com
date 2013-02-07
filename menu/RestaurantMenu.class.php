<?php
class RestaurantMenu {

	protected $menus = array();
	private $filename = "/menu/data.json";
	private $form = false;
	public $returnToTop = true;

	function __construct($form=false) {
		global $site;
		$json = file_get_contents($site['fileroot'].$this->filename);
		$this->menus = json_decode($json, true);
		$this->form = $form;
//		print_r($this->menus);
	}

	function export($path="") {
		$path = ($path == "") ? $this->filename : $path;
		$json = json_encode($this->menus);
		file_put_contents($path, $json);
	}

	function renderLinks() {
		global $h;
		////Menu of menus
		$items = array();
		foreach ($this->menus as $menu) {
			$h->startBuffer();
			$h->a('#'.$menu['id'], $menu['title']);
			$items[] = $h->endBuffer();
		}
		$h->liArray("ul", $items);	
	}

	function render() {
		global $h;
		foreach ($this->menus as $i => $category) {
			$this->renderCategory($category, $i);
			$h->br(2);
			if ($this->returnToTop) $h->a('#top', "Return to Top", 'class="backtotop"');
		}
	}
	
	
	function renderPrint() {
		global $h;
		$newCells = array(0, 2, 4, 5);
		//'width="100%"'
		//$h->otable();
		//$h->otd('valign="top"');
		$h->odiv('class="menu-row"');
		$h->odiv('class="menu-cell left"');
		foreach ($this->menus as $i => $category) {
			$this->renderCategory($category, $i);
			$index = array_search($i, $newCells);
			if ($index > -1 && $index % 2 == 0) {
				$h->cdiv();
				$h->odiv('class="menu-cell right"');
			} else if ($index > -1) {
				$h->cdiv();
				$h->cdiv();
				$h->odiv('class="menu-row"');
				$h->odiv('class="menu-cell left"');
			} else {
				$h->br(2);
			}

		}
		$h->cdiv();
		$h->cdiv();
	}

	function renderCategory($category, $i) {
		global $h;
		////Start menu div
		$h->odiv('class="menu-section" id="'. $category['id'] .'"');
		$h->div($category['title'], 'class="menu-section-title"');		
		$h->tag("a", 'name="'.$category['id'].'"', ' ', false);
		////delegate menu display
		foreach ($category['sections'] as $j => $section) {
		
			
	//print_r($section);
			////Delegate menu section type
			switch ($section['type']) {
				case "grid":
					$this->displayGridMenu($section['items']);		
					break;
				case "menu":
					$this->displayMenu($section['items']);		
					break;
				case "dict":
					$this->displayDictionary($section['items']);
					break;
				case "2-col-center":
					$this->display2ColCtr($section['items']);
					break;
				case "3-col":
					$this->display3Col($section['items']);
					break;				
				case "text":
				default:
					$h->tnl($section['content']);
					break;
			}
		}	
		$h->cdiv();	//close menu-section
	} 	

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

}
?>
