<?php
$host = $_SERVER['HTTP_HOST'];
$self = $_SERVER['PHP_SELF'];

$webroot = "";
////Local
if ($host == 'localhost' || !array_key_exists('HTTP_HOST', $_SERVER)) {
	$webroot = '/pkcar';
}
$webdir = dirname($self);
$subdir = '';
if (stripos($webdir, $webroot."/new") === 0) {
	$subdir .= "/new";
} else if (stripos($webdir, $webroot."/dev") === 0) {
	$subdir .= "/dev";
} else if (stripos($webdir, $webroot."/tst") === 0) {
	$subdir .= "/tst";	
}
$webroot .= $subdir;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Pizza King of Carmel</title>
<meta charset="utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=9"/>
<meta keywords/>
<meta description/>
<link rel="icon" href=""/>
<link rel="shortcut icon" href=""/>
<script type="text/javascript">
//<![CDATA[
var webroot = "<?= $webroot ?>";
//]]>
</script>
<script src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
<script src="<?= $webroot ?>/js/site.js"></script>
<link rel="stylesheet" type="text/css" href="<?= $webroot ?>/css/layout.css" />
<link rel="stylesheet" type="text/css" href="<?= $webroot ?>/css/accessible.css" />
<script src="<?= $webroot ?>/js/superfish/js/superfish.js"></script>
<script src="<?= $webroot ?>/js/superfish/js/hoverIntent.js"></script>
<script src="<?= $webroot ?>/js/superfish/js/jquery.bgiframe.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?= $webroot ?>/js/superfish/css/superfish.css" />
<link rel="stylesheet" type="text/css" href="<?= $webroot ?>/js/superfish/css/superfish-vertical.css" />
<script src="<?= $webroot ?>/js/jquery/jquery-textfill.js"></script>
</head>
<body id="default" class="default">
<div id="page">
	<a href="<?= $webroot ?>" id="header-link">
	<header id="header">
		<img src="<?= $webroot ?>/img/pizzakingme.png" alt="" id="kingme-left"/>
		<img src="<?= $webroot ?>/img/header_logo.png" alt="Pizza King of Carmel"/>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<img src="<?= $webroot ?>/img/magnet_right.png" alt="We Deliver!"/>
		<img src="<?= $webroot ?>/img/pizzakingme.png" alt="" style="float: right;" id="kingme-right"/>
	</header> <!-- close #header -->
	</a> <!-- close a tag -->
	<div id="contentwrapper">
		<div id="contentcolumn" style="margin-left: 0;">
			<div id="layout">
				<div id="content-wrapper" class="column123">
					<div id="content">
						<script src="<?= $webroot ?>/js/star.jquery.js"></script>
						<br />
						<div style="text-align: center;">
							<h1>Under Maintenance. <br />Please check back soon!</h1>
							<img src="<?= $webroot ?>/img/logo_from_sack.png" alt="" align="center"/>
						</div> <!-- close text-align: center -->
						<br /><br />
					</div> <!-- close #content -->
				</div> <!-- close #content-wrapper -->
			</div> <!-- close #layout -->
		</div> <!-- close #contentcolumn -->
	</div> <!-- close #contentwrapper -->
	<footer id="footer">
		&copy; Pizza King of Carmel, 2013 | 
		<a href="<?= $webroot ?>/about.php">About Us</a>
		 | 
		<a href="<?= $webroot ?>/contact.php">Contact Us</a>
		<a href="<?= $webroot ?>/admin" id="admin-link">Admin</a>
	</footer> <!-- close #footer -->
</div> <!-- close #page -->
</body>
</html>


