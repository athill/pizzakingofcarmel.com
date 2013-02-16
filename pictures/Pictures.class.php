<?php
class Pictures {
	private $data = array();

	function __construct($data) {
		$this->data = $data;
	}

	function render() {
		global $h;
		foreach ($this->data['sequence'] as $id) {
			$pic = $this->data['items'][$id];
			$comment = $pic['comment'];
			$file = $id.'.'.$pic['extension'];
			$h->odiv('class="pics-thumbs"');
			$h->startBuffer();
			$h->img('/img/pictures/thumb/'.$file, $comment);
			$img = trim($h->endBuffer());
			$h->a('/img/pictures/'.$file, $img, 'rel="lightbox[pictures]" title="'.$pic['comment'].'"');
			$h->div($pic['comment'], 'class="pics-comment"');
			$h->cdiv();	
		}
	}

	function getId($name) {
		$new_id = preg_replace('/\W/', '', $name);
	}
}
?>