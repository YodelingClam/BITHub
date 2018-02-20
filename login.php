<?php
session_start();
require 'connect.php';
if(isset($_POST["username"]) && isset($_POST['password'])) {
	$username = filter_var($_POST['username'], FILTER_VALIDATE_EMAIL);
	$password = $_POST['password'];
	$query = "SELECT * FROM Users WHERE Email = :username";
	$statement = $db->prepare($query);
	$statement -> bindValue(":username", $username);
	$statement->execute();
	$row = $statement->fetch();
	if (password_verify($password, $row['PasswordHash'])) {
		$_SESSION["userId"] = $row['UserId'];
		$_SESSION['userName'] = $row['FName'];
		$_SESSION['userLName'] = $row['LName'];
		$_SESSION['userPic'] = is_null($row['ProfilePicURL']) ? 'images/users/default.jpg' : 'images/users/'.$row['ProfilePicURL'];
		$_SESSION['userEmail'] = $row['Email'];
	}
	else{
		header('location:index.php?invalidLogin');
		die();
	}
	
}
header('location:index.php');
die();
?>