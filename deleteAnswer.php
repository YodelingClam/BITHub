<?php 
require 'connect.php';
$query = "DELETE FROM answer WHERE AnswerId = :answerid";
$statement = $db -> prepare($query);
$statement -> bindValue(":answerid", $_POST['answer']);
$statement -> execute();

die();
?>
