<?php
session_start();
 if(!isset($_SESSION['user'])) {
	header("Location: login.php");
	die();}
 
if($_SESSION['access'] != 2) {
	die("Access Denied");}
?>
 
<p>Welcome <?= $_SESSION['user'] ?>!</p>
 
<p><strong>You are in your login page that only you can see!</strong></p>
 
<p>isnt this pretty cool?</p>
 
<p><a href="login.php?out=1">Logout</a></p>
