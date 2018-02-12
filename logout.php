<?php
if(true) {
	session_start();
	$_SESSION["userId"] = "";
	session_destroy();
	header("location:index.php");
	die();
}
?>