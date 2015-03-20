<?php
class RestaurantMenu {

	protected $data = array();
	private $form = false;
	public $returnToTop = true;
	private $basename = '';

	function __construct($data, $form=false) {
		$this->data = $data;
		$this->form = $form;
//		print_r($this->data);
	}

	function export($path="") {
		$path = ($path == "") ? $this->filename : $path;
		$json = json_encode($this->data);
		file_put_contents($path, $json);
	}

	function renderLinks() {
		global $h;
		////Menu of menus
		$items = array();
		foreach ($this->data as $section) {
			$h->startBuffer();
			$h->a('#'.$section['id'], $section['title']);
			$items[] = trim($h->endBuffer());
		}
		$h->liArray("ul", $items);	
	}

	function render() {
		global $h;
		if ($this->form) {
			$h->oform('submit.php');
		}
		foreach ($this->data as $i => $section) {
			$this->renderSection($section, $i);
			$h->br(2);
			$h->startBuffer();
			$h->a('#top', "Return to Top", 'class="backtotop"');
			$backtotop = $h->endBuffer();
			if ($this->form) {
				$h->odiv('class="row"');
				$h->div($backtotop, 'class="left"');
				$h->odiv('class="right"');
				$h->submit('s', 'Update');
				$h->button('menu-preview', "Preview", 'class="menu-preview" id="menu-preview-'.$i.'"');
				$h->submit('menu-publish', "Publish", 'id="menu-publish-'.$i.'"');
				$h->cdiv();
				$h->cdiv('.row');
				$h->br();
			} else {
				if ($this->returnToTop) $h->tnl($backtotop);
			}
		}
		if ($this->form) {
			$h->cform();
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
		foreach ($this->data as $i => $section) {
			$this->renderSection($section, $i);
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

	function renderSection($section, $i) {
		global $h;
		////Start menu div
		$h->odiv('class="menu-section" id="'. $section['id'] .'"');
		$h->div($section['title'], 'class="menu-section-title"');		
		$h->tag("a", 'name="'.$section['id'].'"', ' ', false);
		////delegate menu display
		foreach ($section['sections'] as $j => $section) {
			$this->basename = $section['type'].'_'.$i.'_sections_'.$j;
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
				case "header":
					$this->displayHeader($section['content']);
					break;
				case "feast":
					$this->displayFeast($section['items']);
				case "text":
				default:
					if ($this->form) {
						$h->editor($this->basename.'_content', $section['content']);
					} else {
						$h->tnl($section['content']);
					}
					break;
			}
		}	
		$h->cdiv('.menu-section');	//close menu-section
	} 	

	function displayHeader($content) {
		global $h;
		if ($this->form) {
			$h->intext($this->basename.'_content', $content);
		} else {
			$h->h4($content);
		}
	}

	function displayFeast($items) {
		global $h;
		foreach ($items as $k => $item) {
			if ($this->form) {
				$h->odiv('class="feast-item"');
				$h->intext($this->basename.'_items_'.$k.'_title', $item['title'], 'class="feast-title"');
				$h->intext($this->basename.'_items_'.$k.'_toppings', $item['toppings'], 'class="feast-title"');
				$h->cdiv();
			} else {
				$h->odiv('class="feast-item"');
				$h->span($item['title'], 'class="feast-title"');
				$h->span($item['toppings'], 'class="feast-toppings"');
				$h->cdiv();
			}
		}
	}

	function displayDictionary($items) {
		global $h;
		$h->otag('dl', 'class="pk-menu-dict"');
		foreach ($items as $k => $item) {
			// print_r($item);
			if ($this->form) {
				$h->odt();
				$h->intext($this->basename.'_items_'.$k.'_left', $item['left']);
				$h->cdt();
				$h->odd();
				$h->editor($this->basename.'_items_'.$k.'_right', $item['right'], 'size="50"');
				$h->cdd();

			} else {
				$h->dt($item['left'].':');
				$h->dd($item['right']);
			}
		}
		$h->ctag('dl');
	}

	function displayGridMenu($items) {
		global $h;
		global $webroot;
		
		$headers = array('', '8"', '10"', '14"', '16"');
		$h->otable('class="menu-table"');
		foreach ($headers as $header) {
			$h->th($header);
		}
		foreach ($items as $k => $item) {
			$basename = $this->basename.'_items_'.$k;
			$h->cotr();
			$h->otd();
			$name = $item['name'];
			
			if (array_key_exists('img', $item) && !$this->form) {
				$src = $webroot.'/img/pictures/'.$item['img'];
				$thumb = $webroot.'/img/pictures/thumb/'.$item['img'];
				$name = '<img src="'.$thumb.'" rel="'.$src.'" class="tooltip" ' .
					'width="50" alt="'.$item['name'].'" /> ' . $name;
			}
			$atts = 'class="menu-item-name"';
			if ($this->form) {
				$h->odiv($atts);
				$h->intext($basename.'_name', $name);
				$h->cdiv();				
			} else {
				$h->div($name, $atts);			
			}
			// if (array_key_exists("toppings", $item)) {
			// 	$atts = 'class="menu-item-descr"';
			// 	if ($this->form) {
			// 		$h->odiv($atts);
			// 		$h->textarea($basename.'_toppings', $item['toppings']);
			// 		$h->cdiv();
			// 	} else {
			// 		$h->div($item['toppings'], $atts);
			// 	}
			// }			
			$h->ctd();
			foreach ($item['prices'] as $l => $price) {
				if ($this->form) {
					$h->otd();
					$h->intext($basename.'_prices_'.$l, $price, 'size="6"');
					$h->ctd();
				} else {
					$h->td(number_format($price, 2));
				}
			}
		}
		$h->ctable();
	}

	function displayMenu($items) {
		global $h;
		global $webroot;
		foreach ($items as $k => $item) {
			$basename = $this->basename.'_items_'.$k;
			$h->odiv('class="menu-item"');
			$h->odiv('class="menu-item-name-price-row"');
			$name = $item['name'];
			if (array_key_exists('img', $item) && !$this->form) {
				$src = $webroot.'/img/pictures/'.$item['img'];
				$thumb = $webroot.'/img/pictures/thumb/'.$item['img'];
				$name = '<img src="'.$thumb.'" rel="'.$src.'" class="tooltip" ' .
					'width="50" alt="'.$item['name'].'" /> ' . $name;
			}
			$atts = 'class="menu-item-name left"';
			if ($this->form) {
				$h->odiv($atts);
				$h->intext($basename.'_name', $name);
				$h->cdiv();
			} else {
				$h->div($name, $atts);	
			}
			$atts = 'class="menu-item-price right"';
			if ($this->form) {
				$h->odiv($atts);
				$h->intext($basename.'_price', $item['price']);
				$h->cdiv();
			} else {
				$price = preg_replace("/;/", "<br />", $item['price']);
				$price = preg_replace("/:/", "&nbsp;", $price);
				$h->div($price, $atts);
			}
			
			$h->cdiv('.menu-item-name-price-row');
			$atts = 'class="menu-item-descr"';
			if ($this->form) {
				$h->odiv($atts);
				$h->editor($basename.'_descr', $item['descr']);
				$h->cdiv();
			} else {
				$h->div($item['descr'], $atts);
			}
			$h->cdiv('menu-item');
		}
	}                                                
		      
	function display2ColCtr($items) {
		global $h;
		$h->odiv('class="pk-menu-2-col-center"');
		foreach ($items as $k => $item) {
			$basename = $this->basename.'_items_'.$k;
			$h->odiv('class="row"');
			if ($this->form) {
				$h->odiv('class="column"');
				$h->intext($basename.'_left', $item['left']);
				$h->cdiv('.column');
				$h->odiv('class="column"');
				$h->intext($basename.'_right', $item['right']);
				$h->cdiv('.column');				

			} else {
				$h->div($item['left'], 'class="column"');
				$h->div($item['right'], 'class="column"');				
			}
			$h->cdiv();
		}
		$h->cdiv();                          
	}
		          
	function display3Col($items) {
		global $h;
		$h->odiv('class="pk-menu-3-col"');
		foreach ($items as $k => $item) {
			$basename = $this->basename.'_items_'.$k;
			if (!$this->form) $h->odiv('class="column"');
			if ($this->form) {
				$h->odiv('class="title"');
				$h->intext($basename.'_title', $item['title']);
				$h->cdiv('.title');
				$h->odiv('class="descr"');
				$h->editor($basename.'_descr', $item['descr'], 'style="width: 99%;"');
				$h->cdiv('.descr');
			} else {
				$h->div($item['title'], 'class="title"');
				$h->div($item['descr'], 'class="descr"');
			}
			if (!$this->form) $h->cdiv('.column');			
		}
		$h->cdiv();                          
	} 


	function update($newdata=$_POST) {
		global $h, $utils;
		$data = $this->data;
		$tmp = array();
		foreach ($newdata as $key => $val) {
			if (strpos($key, '_') === false) {
				continue;
			}
			$parts = explode('_', $key);
			$type = array_shift($parts);
			$path = implode('_', $parts);
			// $h->tbr($type.'-----'.$path);
			$utils->setArrayItem($data, $path, $val);

		}
		return $data;
	}

	public function publish($pub_file) {
		global $utils;
		$utils->setJson($pub_file, $this->data);
	}

}
?>
