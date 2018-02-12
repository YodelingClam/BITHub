<?php 
function file_upload_path($original_filename, $upload_subfolder_name = 'images\users') {
	$current_folder = dirname(__FILE__);
	$path_parts = pathinfo($original_filename);
	$path_segments = [$current_folder, $upload_subfolder_name, $_POST['firstname'].'_'.$_POST['lastname'].'.'.$path_parts['extension']];
	return join(DIRECTORY_SEPARATOR, $path_segments);
}

function file_is_an_image($temporary_path, $new_path) {
	$allowed_mime_types      = ['image/gif', 'image/jpeg', 'image/png'];
	$allowed_file_extensions = ['gif', 'jpg', 'jpeg', 'png'];
	$path_parts = pathinfo($_FILES['image']['name']);
	$actual_file_extension   = $path_parts['extension'];
	$actual_mime_type        = getimagesize($temporary_path)['mime'];
	$file_extension_is_valid = in_array($actual_file_extension, $allowed_file_extensions);
	$mime_type_is_valid      = in_array($actual_mime_type, $allowed_mime_types);

	return $file_extension_is_valid && $mime_type_is_valid;
}

if ($_POST['password'] == $_POST['password2']) {
	$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
	$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
	$fname = filter_var($_POST['firstname'], FILTER_SANITIZE_STRING);
	$lname = filter_var($_POST['lastname'], FILTER_SANITIZE_STRING);
	$image_upload_detected = isset($_FILES['image']) && ($_FILES['image']['error'] === 0);

	if ($image_upload_detected) { 
		$image_filename       = $_FILES['image']['name'];
		$temporary_image_path = $_FILES['image']['tmp_name'];
		$new_image_path       = file_upload_path($image_filename);

		if (file_is_an_image($temporary_image_path, $new_image_path)) { 
			move_uploaded_file($temporary_image_path, $new_image_path);
		}
	}
	$path_parts = pathinfo($image_filename);
	$ProfilePicURL = $_POST['firstname'].'_'.$_POST['lastname'].'.'.$path_parts['extension'];
	require 'connect.php';
	$query = "INSERT INTO users (FName, LName, Email, PasswordHash, ProfilePicURL) VALUES (:fname, :lname, :email, :passwordhash, :ProfilePicURL)";
	$statement = $db -> prepare($query);
	$statement -> bindValue(":fname", $fname);
	$statement -> bindValue(":lname", $lname);
	$statement -> bindValue(":email", $email);
	$statement -> bindValue(":passwordhash", $password);
	$statement -> bindValue(":ProfilePicURL", $ProfilePicURL);
	$statement -> execute();

}
header('location:index.php');
die();
?>