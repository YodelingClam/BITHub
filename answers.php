<?php 
require 'connect.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>BITHub</title>
</head>
<body>
	<?php include 'menu.php' ?>
	<?php if (isset($_GET['search']) && $_GET['search'] == 'recent'): ?>
		<?php 
		$search = filter_var($_GET['search'], FILTER_SANITIZE_STRING);
		$query = "SELECT * FROM question JOIN users USING(UserId) JOIN course USING(CourseId) ORDER BY TimeStamp DESC";
		$statement = $db->prepare($query);		
		$statement -> execute(); 
		$questions = $statement->fetchAll();
		?>
		<?php foreach ($questions as $key => $question): ?>
			<div class="question">
				<h1><?= $question['Title'] ?></h1>
				<h4><?= $question['TimeStamp'] ?></h4>
				<h4>Course: <?= $question['CourseName'] ?> <br> Tags: <?= $question['Tags'] ?></h4>
				<p><?= $question['Content'] ?></p>
				<a href="#" onclick="$('#answer<?=$question['QuestionId']?>').show();">Answer</a>
			</div>
			<div id="answer<?=$question['QuestionId']?>" style="display: none;">
				<form action="newAnswer.php" method="post" style="width: 50%;">
					<textarea id="editor<?=$question['QuestionId']?>" name="content" rows='10' cols="40" style="width: 50%; height: 250px;"></textarea><br>
					<?php 
					require_once 'securimage/securimage.php';
					echo "<div id='captcha_container_1'>\n";
					echo Securimage::getCaptchaHtml();
					echo "\n</div>\n"; 
					?>
					<button type="submit">Submit</button><br>
					<button type="button" onclick="$('#answer<?=$question['QuestionId']?>').hide();">Cancel</button>
					<input type="hidden" name="questionid" value="<?=$question['QuestionId']?>">
				</form>
				<script>
					ClassicEditor
					.create( document.querySelector( '#editor<?=$question['QuestionId']?>' ) )
					.catch( error => {
						console.error( error );
					} );
				</script>
			</div>
		<?php endforeach ?>
		
	<?php endif ?>
</body>
</html>