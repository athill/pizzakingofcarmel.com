<?php
class Pictures {
	private $data = array();

	function __construct($data) {
		$this->data = $data;
	}

	function render($form=false) {
		global $h;
		if ($form) { 
			$h->oform('');
			$h->oul('id="pics"');

		} else {
			$h->odiv('id="pics"');
		}
		foreach ($this->data['sequence'] as $i => $id) {
			$pic = $this->data['items'][$id];
			$title = $pic['title'];
			$file = $id.'.'.$pic['extension'];
			//// thumbnail
			$h->startBuffer();
			$h->img('/img/pictures/thumb/'.$file, $title);
			$thumb = trim($h->endBuffer());
			//// form
			if ($form) {
				$h->oli('class="pics-edit" id="'.$id.'"');
				$h->div($thumb, 'class="pics-img"');
				$h->odiv('class="pics-fields"');
				$name = 'pic_'.$id;
				$h->label($name.'_title', 'Title:');
				$h->intext($name.'_title', $pic['title']);
				$h->br();
				// http://stackoverflow.com/questions/8806058/delete-jquery-ui-sortable-list-item
				$h->button($i, 'Delete', 'class="delete"');
				$h->cdiv('.pics-fields');
				$h->cli('.pics-edit');
			//// display
			} else {
				//// render for lightbox
				$h->odiv('class="pics-thumbs"');
				$h->a('/img/pictures/'.$file, $thumb, 'rel="lightbox[pictures]" title="'.$pic['title'].'"');
				$h->div($pic['title'], 'class="pics-title"');
				$h->cdiv();	
			}
		}
		if ($form) {
			$h->odiv('class="add"');
			$h->file('img');
			$h->label('title', 'Title:');
			$h->intext('title');
			$h->cdiv('.add');
			$h->cul('#pics');
			$h->hidden('sequence', implode(',', $this->data['sequence']));
			$h->cform();
		} else {
			$h->cdiv('#pics');	
		}

		
	}

	function getId($name) {
		$new_id = preg_replace('/\W/', '', $name);
	}
}
?>