<?php 
session_start();
require 'connect.php';
include_once 'securimage/securimage.php';
$securimage = new Securimage();

if ($securimage->check($_POST['captcha_code']) == false) {
	echo "The security code entered was incorrect.<br /><br />";
	echo "Please go <a href='javascript:history.go(-1)'>back</a> and try again.";
	die();
}
if (strlen($_POST['content']) > 0) {
	$query = "INSERT INTO answer (UserId, QuestionId, Content) VALUES (:userid, :questionid, :content)";
	$statement = $db -> prepare($query);
	$statement -> bindValue(":userid", $_SESSION['userId']);
	$statement -> bindValue(":questionid", $_POST['questionid']);
	$statement -> bindValue(":content", $_POST['content']);
	$statement -> execute();
	header("Location: question.php?post=".$_POST['questionid']);
	die();
}
?>