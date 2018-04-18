<?php
session_start();
require 'connect.php';
$title = filter_var(trim($_POST['title']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$content = $_POST['content'];//filter_var(trim($_POST['content']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$course = filter_var($_POST['course'], FILTER_VALIDATE_INT);
$questionid = $_POST['questionid'];
if (strlen($title) > 0 && strlen($content) > 0 && $course != null) {
	$query = "UPDATE question SET CourseId=:course, Title=:title, Content=:content WHERE QuestionId = :questionid";
	$statement = $db -> prepare($query);
	$statement -> bindValue(":title", $title);
	$statement -> bindValue(":content", $content);
	$statement -> bindValue(":course", $course);
	$statement -> bindValue(":questionid", $questionid);
	$statement -> execute();

	header("Location: question.php?post=$questionid");
	die();
}
?>