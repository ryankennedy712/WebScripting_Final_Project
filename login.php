<?php
session_start();
 
include("authenticate.php");
 
if(isset($_GET['out'])) {
	session_unset();
	$_SESSION = array();
	unset($_SESSION['user'],$_SESSION['access']);
	session_destroy();
}
 
if(isset($_POST['userLogin'])){
	if(authenticate($_POST['userLogin'],$_POST['userPassword']))
	{
		header("Location: protected.php");
		die();
	} else {
		$error = 1;
	}
}
if(isset($error)) echo "Login failed: Incorrect user name, password, or rights<br />";
if(isset($_GET['out'])) echo "Logout successful";
?>
<html>
<p>NOTICE: THIS IS ONLY FOR ADMINISTRATORS, ALL OTHER LOGINS WILL BE DENIED</p>
<p>Login with your account on RyanAD.local</p>
<form action="login.php" method="post">
	User: <input type="text" name="userLogin" /><br />
	Password: <input type="password" name="userPassword" />
	<input type="submit" name="submit" value="Submit" />
</form>
</html>
