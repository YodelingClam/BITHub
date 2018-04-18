<?php 
require 'connect.php';
$query = "DELETE FROM question WHERE QuestionId = :questionid";
$statement = $db -> prepare($query);
$statement -> bindValue(":questionid", $_POST['question']);
$statement -> execute();

die();
?>
