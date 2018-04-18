<?php
require 'connect.php';
$query = "SELECT * FROM course ORDER BY CourseAbv";
$statement = $db->prepare($query);	
$statement -> execute(); 
$courses = $statement->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
	<title>New Post</title>
	<script src="https://cdn.ckeditor.com/ckeditor5/1.0.0-beta.1/classic/ckeditor.js"></script>
</head>
<body>
	<?php include 'menu.php'; ?>
	<form style="width: 50%; margin: auto;" id="newPost" method="post" action="submitPost.php">
		<fieldset>
			<input id="title" name="title" type="text" placeholder="Title of question" required autofocus/><br>
			<textarea id="editor" name="content" rows='10' style="width: 100%; height: 250px;"></textarea><br>
			<label for="course">Course:</label>
			<select id="course" name="course">
				<?php foreach ($courses as $key => $value): ?>
					<option value="<?= $value['CourseId'] ?>"> <?= $value['CourseAbv'] .' - '. $value['CourseName']?></option>
				<?php endforeach ?>
			</select>

			<?php 
			require_once 'securimage/securimage.php';
			echo "<div id='captcha_container_1'>\n";
			echo Securimage::getCaptchaHtml();
			echo "\n</div>\n"; 
			?>

		<button type="submit">Submit</button><br>
		<button type="reset">Reset</button>
		</fieldset>
		<script>
			ClassicEditor
			.create( document.querySelector( '#editor' ) )
			.catch( error => {
				console.error( error );
			} );
		</script>
	</form>
	<style>
		.ck-editor__editable
		{
		    height: 500px;
		}
	</style>
</body>
</html>