<?php 
if (isset($_POST['username'])) {
	//print("here");
	include($GLOBALS['fileroot'] . "/includes/db.php");
	$query = "SELECT admin, blog FROM login WHERE username='" . $_POST['username']  . "'" . 
		"AND password=MD5('" .  $_POST['password']  . "')";
	//print($query);
	$record = mysql_query($query);
	if (mysql_num_rows($record) > 0) {
		list($_SESSION['admin'], $_SESSION['blog']) = mysql_fetch_array($record);
		print("<div class=\"alert\">You are successfully logged in.</div>");
	} else {
		session_destroy();
		print("<div class=\"alert\">Invalid Username or password.</div>");
	}
}
?>



<form action="<?php echo $GLOBALS['webroot'] . "/?view=" . $GLOBALS['view']; ?>" method="post">
<br /><br />
<div class="row">
	<label for="username" class="left">Username:</label>
	<span class="right">
	<input type="text" id="username" name="username" size="15" maxlength="10" />
	</span>
</div>
<div class="row">
	<label for="password" class="left">
	Password:
	</label>
	<span class="right">
	<input type="password" id="password" name="password" size="15" maxlength="20" />
	</span>
</div>
<div class="row">
	<span class="left">&nbsp;</span>
	<span class="right" style="text-align: right;">
	<input type="submit" value="Login" />
	</span>
</div>	
</form>
<script type='text/javascript'>
document.forms[0].username.focus();
</script>