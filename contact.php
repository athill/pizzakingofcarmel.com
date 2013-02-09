<?php
include("inc/application.php");

$h->startBuffer();

$h->email("PizzaKingOfCarmel@yahoo.com");

$email = trim($h->endBuffer());

$contacts = array(
	array('left'=>"Address", 
		'right'=>"Pizza King of Carmel<br />301 E. Carmel Dr., Suite A-800<br />" .
		"Carmel, IN 46032"),
	array('left'=>"Telephone", 'right'=>"317-848-7994"),
	array('left'=>"Email", 'right'=>$email),
);

$h->odiv('id="contact-us"');
$h->dictionaryGrid($contacts);
$h->br(2);
$h->div('<strong>Note:</strong> Email not checked daily. Please call the store if there is an immediate issue.', 'style="text-align: center;"');
$h->cdiv();

$template->footer();
?>
