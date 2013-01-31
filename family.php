<?php
include("inc/application.php");

$family = array(
	array('name'=>"Carmel", 
		'addr'=>"301 E. Carmel Dr., Suite A-800 ",
		'addr2'=>"Carmel, IN 46032",
		'phone'=>"317-848-7449"				
	),
	array('name'=>"Rushville", 
		'addr'=>"211 N. Perkins St.",
		'addr2'=>"Rushville, IN 46173",
		'phone'=>"756-932-2212"				
	),
	array('name'=>"Rushville North", 
		'addr'=>"1554 N. Main St.",
		'addr2'=>"Rushville, IN 46173",
		'phone'=>"756-932-4243"				
	),	
	array('name'=>"Greensburg", 
		'addr'=>"1005 N. Lincoln St.",
		'addr2'=>"Greensburg, IN 47240",
		'phone'=>"812-663-7677"				
	),	
	array('name'=>"Greensburg Bypass", 
		'addr'=>"915 Kathy's Way Ste. A",
		'addr2'=>"Greensburg, IN 47240",
		'phone'=>"812-662-9677"				
	),		
	array('name'=>"Liberty", 
		'addr'=>"201 N. Main St.",
		'addr2'=>"Liberty, IN 47353",
		'phone'=>"765-458-5775",
		'email'=>'pizzakingliberty@frontier.com'				
	),		
	array('name'=>"Batesville", 
		'addr'=>"18 Saratoga Drive",
		'addr2'=>"Batesville, IN 47006",
		'phone'=>"812-932-5464"
	),
);

$dict = array();
for ($i = 0; $i < count($family); $i++) {
	$left = $family[$i]['name'];
	$right = $family[$i]['addr'] . '<br />' . $family[$i]['addr2']; 
	$right .=  '<br />Phone: ' .  $family[$i]['phone'];
	if (array_key_exists('email', $family[$i])) {
		$h->startBuffer();
		$h->email($family[$i]['email']);
		$email =  trim($h->endBuffer());
		$right .=  '<br />Email: ' .  $email;
	}
	$dict[] = array('left'=>$left, 'right'=>$right );
}
/*
Rushville:  211 n perkins st., rushville, in.  46173  765-932-2212
Rushville North:  1554 N main st, rushville, in. 46173,   765-932-4243
Greensburg:  1005 N Lincoln St, Greensburg, in.  47240  812-663-7677
Greensburg Bypass:  915 Kathy's Way Ste. A, Greensburg, IN.  47240   812-662-9677
Liberty:  201 N Main St, Liberty, IN.  47353   765-458-5775 (pizzakingliberty@verizon.net)
*/

$h->odiv('id="pk-family"');
$h->dictionaryGrid($dict);
$h->cdiv();



$template->footer();
?>
