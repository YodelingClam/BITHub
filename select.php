<?php 
session_start();
require 'connect.php';

$query = "UPDATE question SET Selected = null";
$statement = $db -> prepare($query);
$statement -> execute();

$query = "UPDATE question SET Selected = :answerid WHERE QuestionId = :questionid";
$statement = $db -> prepare($query);
$statement -> bindValue(":answerid", $_POST['answer']);
$statement -> bindValue(":questionid", $_POST['question']);
$statement -> execute();
die();

?>