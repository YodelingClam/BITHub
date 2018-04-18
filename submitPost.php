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
$title = filter_var(trim($_POST['title']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
//$content = filter_var(trim($_POST['content']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$course = filter_var($_POST['course'], FILTER_VALIDATE_INT);
if (strlen($title) > 0 && strlen($_POST['content']) > 0 && $course != null) {
	$query = "INSERT INTO question (Title, Content, UserId, CourseId) VALUES (:title, :content, :user, :course)";
	$statement = $db -> prepare($query);
	$statement -> bindValue(":title", $title);
	$statement -> bindValue(":content", $_POST['content']);
	$statement -> bindValue(":course", $course);
	$statement -> bindValue(":user", $_SESSION['userId']);
	$statement -> execute();
	header("Location: browse.php?type=search&by=");
	die();
}
?>