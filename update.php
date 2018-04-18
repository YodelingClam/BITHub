<?php 
session_start();

require 'connect.php';

if ($_POST['type'] == 'email') {
	$email = filter_var($_POST['name'], FILTER_VALIDATE_EMAIL);
	echo $email;
	$query = "UPDATE Users SET Email = :email WHERE UserId = :userId";
	$statement = $db -> prepare($query);
	$statement -> bindValue(":userId", $_SESSION['userId']);
	$statement -> bindValue(":email", $email);
	$statement -> execute();

	$_SESSION['userEmail'] = $email;
}

if ($_POST['type'] == 'image') {

	include 'ImageResize.php';
	function file_upload_path($original_filename, $upload_subfolder_name = 'images/users') {
		$current_folder = dirname(__FILE__);
		$path_parts = pathinfo($original_filename);
		$path_segments = [$current_folder, $upload_subfolder_name, $_SESSION['userName'].'_'.$_SESSION['userLName'].'.'.$path_parts['extension']];
		return join(DIRECTORY_SEPARATOR, $path_segments);
	}

	function file_is_an_image($temporary_path, $new_path) {
		$allowed_mime_types      = ['image/jpeg', 'image/png'];
		$allowed_file_extensions = ['jpg', 'jpeg', 'png'];
		$path_parts = pathinfo($_FILES['image']['name']);
		$actual_file_extension   = $path_parts['extension'];
		$actual_mime_type        = getimagesize($temporary_path)['mime'];
		$file_extension_is_valid = in_array(strtolower($actual_file_extension), $allowed_file_extensions);
		$mime_type_is_valid      = in_array($actual_mime_type, $allowed_mime_types);

		return $file_extension_is_valid && $mime_type_is_valid;
	}

	$image_upload_detected = isset($_FILES['image']) && ($_FILES['image']['error'] === 0);

	if ($image_upload_detected) { 
		$image_filename       = $_FILES['image']['name'];
		$temporary_image_path = $_FILES['image']['tmp_name'];
		$new_image_path       = file_upload_path($image_filename);

		if (file_is_an_image($temporary_image_path, $new_image_path)) { 
			move_uploaded_file($temporary_image_path, $new_image_path);
			$image = new \Gumlet\ImageResize($new_image_path);
			$image->resizeToWidth(300);
			$image->save($new_image_path);
		}
	}
	$path_parts = pathinfo($image_filename);
	$ProfilePicURL = $_SESSION['userName'].'_'.$_SESSION['userLName'].'.'.$path_parts['extension'];
	$query = "UPDATE Users SET ProfilePicURL = :ProfilePicURL WHERE UserId = :userId";
	$statement = $db -> prepare($query);
	$statement -> bindValue(":userid", $_SESSION['userId']);
	$statement -> bindValue(":ProfilePicURL", $ProfilePicURL);
	$statement -> execute();

	$_SESSION['userPic'] = 'images/users/'.$ProfilePicURL;
	print_r($_FILES);
}
?>
