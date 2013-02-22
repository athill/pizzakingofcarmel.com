<?php
class Pictures {
	private $data = array();
	private $imgdir = '/img/pictures';

	function __construct($data, $imgdir='') {
		$this->imgdir = ($imgdir == '') ? $this->imgdir : $imgdir;
		$this->data = $data;
	}

	function render($form=false) {
		global $h;
		$h->pa($this->data);
		if ($form) {
			$h->oform('submit.php', 'post', 'enctype="multipart/form-data"');
			$h->ofieldset('Add', 'class="add"');
			$h->label('img', 'Image:');
			$h->file('img');
			$h->br();
			$h->label('title', 'Title:');
			$h->intext('title');
			$h->br();
			$h->submit('add', 'Add');
			$h->cfieldset('.add');
			$h->cform();
		}
		if ($form) { 
			$h->ofieldset('Update');
			$h->oform('submit.php');
			$h->oul('id="pics"');

		} else {
			$h->odiv('id="pics"');
		}
		foreach ($this->data['sequence'] as $i => $id) {
			$pic = $this->data['items'][$id];
			// $h->pa($pic);
			$title = $pic['title'];
			$file = $id.'.'.$pic['extension'];
			//// thumbnail
			$h->startBuffer();
			$h->img($this->imgdir.'/thumb/'.$file, $title);
			$thumb = trim($h->endBuffer());
			//// form
			if ($form) {
				$h->oli('class="pics-edit" id="'.$id.'"');
				$h->div($thumb, 'class="pics-img"');
				$h->odiv('class="pics-fields"');
				$name = 'pic_'.$id;
				$h->label($name.'_title', 'Title:');
				$h->intext($name.'_title', $pic['title']);
				$h->br(2);
				// http://stackoverflow.com/questions/8806058/delete-jquery-ui-sortable-list-item
				$h->input('checkbox', $name.'_delete', 'Delete', 'class="delete"');
				$h->label($name.'_delete', 'Delete');
				$h->cdiv('.pics-fields');
				$h->cli('.pics-edit');
			//// display
			} else {
				//// render for lightbox
				$h->odiv('class="pics-thumbs"');
				$h->a($this->imgdir.'/'.$file, $thumb, 'rel="lightbox[pictures]" title="'.$pic['title'].'"');
				$h->div($pic['title'], 'class="pics-title"');
				$h->cdiv();	
			}
		}
		if ($form) {
			$h->submit('s', 'Save');
			$h->cul('#pics');
			$h->hidden('sequence', implode(',', $this->data['sequence']));
			$h->cform();
			$h->cfieldset();
		} else {
			$h->cdiv('#pics');	
		}

		
	}

	function add() {
		global $h, $site;
		$data = $this->data;
		$img = $_FILES['img'];
        /* Data structure //
        [name] => Screenshot from 2012-07-23 07:48:40.png
        [type] => image/png
        [tmp_name] => /tmp/phpR0NOKQ
        [error] => 0
        [size] => 257305
        */		
		$from = $img['tmp_name'];
		$info = getimagesize($from);
		/*  Image info
		    [0] => 1280	////width
		    [1] => 1024 ////height
		    [2] => 3    
		    [3] => width="1280" height="1024"
		    [bits] => 8
		    [mime] => image/png
		*/
		$h->pa($info);
		$title = $_POST['title'];
		$id = $this->getId($title);
		$file_name_arr = explode('.', $img['name']);
		$ext = array_pop($file_name_arr);
		$filename = $id.'.'.$ext;
		////Add main image
		$to = $site['fileroot'].$this->imgdir.'/'.$filename;
		$width = 600;
		$convert = '/usr/bin/convert '.$from.' -size '.$width.' '.$to;
		$h->tbr($convert);
		$retval = system($convert);
		
		////Add thumbnail
		$to = $site['fileroot'].$this->imgdir.'/thumb/'.$filename;
		$width = 200;
		$convert = '/usr/bin/convert '.$from.' -size '.$width.' '.$to;
		$h->tbr($convert);
		$retval = system($convert);
		// // copy($img['tmp_name'], $this->imgdir.'/'.$filename);
		//// Update data
		$tmp = array(
			'title'=>$title,
			'extension'=>$ext
		);
		$data['items'][$id] = $tmp;
		$data['sequence'][] = $id;
		//$h->pa($this->data);
		return $data;
	}

	function update() {
		global $h;
		$h->pa($_POST);
		$prefix = 'pic_';
		$data = $this->data;
		$sequence = explode(',', $_POST['sequence']);
		$h->pa($sequence);
		foreach ($sequence as $i => $id) {
			$name = $prefix.$id;
			$title = $name.'_title';
			// $h->tbr($title);
			if (array_key_exists($title, $_POST)) {
				$data['items'][$id]['title'] = $_POST[$title];
				$h->tbr('title: '. $title);
			}
			//// else if?
			if (array_key_exists($name.'_delete', $_POST)) {
				$h->tbr('delete: '. $name.'_delete');
				////delete the item
				////delete from sequence
				////delete from pictures
				////delete from thumbs
			}			
		}
		return $data;

	}

	function getId($name) {
		$new_id = preg_replace('/\W/', '', $name);

		return $new_id;
	}
}
?>