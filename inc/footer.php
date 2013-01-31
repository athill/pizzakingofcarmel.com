<?php
$h->cdiv();	////close content
$h->cdiv(); ////closecontentwrapper

$h->odiv('id="leftcolumn"');
$sfmenu->displayMenu();
$h->cdiv();


//$h->cdiv(); ////close main
//$h->cdiv(); ////close main

$h->odiv('id="footer"');
$h->tnl("&copy; Pizza King of Carmel, ".date('Y')." | ");
$h->local("/about.php", "About Us");  
$h->tnl(" | ");
$h->local("/contact.php", "Contact Us");
$h->cdiv();	////close footer  


$h->chtml();
?>
