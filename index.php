<?php 
$userId = null;
$userPic = null;
require 'connect.php';
$query = "SELECT * FROM course ORDER BY CourseAbv";
$statement = $db->prepare($query);	
$statement -> execute(); 
$courses = $statement->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
	<title>BITHub</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="styles/index.css">
	<link rel="stylesheet" type="text/css" href="styles/browse.css">
</head>
<body>
	<?php include 'menu.php'; ?>
	<div id="content">
		<div class="row">
			<div id="redditThing" class="column">
				<script src='https://redditjs.com/subreddit.js' data-subreddit='programming' data-theme='dark' ></script>
				<?php if (isset($_SESSION['userId'])): ?>
					<form style="width: 100%; margin: auto;" id="newPost" method="post" action="submitPost.php">
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
					height: 150px;
					width: 100%;
				}
				</style>
				<?php endif ?>
			</div>
		<div class="column">
			<?php 
			$query = "SELECT * FROM question JOIN users USING(UserId) JOIN course USING(CourseId) ORDER BY TimeStamp DESC";
			$statement = $db->prepare($query);	
			$statement -> execute(); 
			$questions = $statement->fetchAll();
			?>
			<div class="mainUl" style="width: auto;">
				<?php foreach ($questions as $key => $question): ?>
					<div class="mainLi" style="width: auto;">
						<div class="question" style="width: auto;">
							<?php $pic = 'images/users/'.$question["ProfilePicURL"] ?>
							<a href="question.php?post=<?= $question['QuestionId'] ?>&course=<?= $question['CourseName'] ?>&title=<?= $question['Title'] ?>"><h1><?= $question['Title'] ?></h1></a>
							<h3><?= $question['FName'].' '.$question['LName'] ?></h3>
							<p style="display: inline;"><?= $question['TimeStamp'] ?></p>
							<p style="margin: 0px;">Course: <?= $question['CourseName'] ?></p>
							<hr>
							<p><?= $question['Content'] ?></p>
							<?php if ((isset($_SESSION['admin']) && $_SESSION['admin'] > 0) || (isset($_SESSION['userId']) && $_SESSION['userId'] == $question['UserId'])): ?>
								<a href="question.php?post=<?= $question['QuestionId'] ?>&edit">Edit</a>
								<a href="#" onclick="$('#answer<?=$question['QuestionId']?>').show();">Answer</a>
							<?php endif ?>
							<?php if (isset($_SESSION['admin']) && $_SESSION['admin'] > 1): ?>
								<a href="#" onclick="
								$.ajax({
									async: true,
									url: 'delete.php',
									type: 'POST',
									data: { question: <?= $question['QuestionId'] ?> },
									success: function(){location.reload();} 
								});
								">Delete</a>
							<?php endif ?>
						</div>


						<div id="answer<?=$question['QuestionId']?>" style="display: none;">
							<form action="newAnswer.php" method="post" style="width: 90%;">
								<textarea id="editor<?=$question['QuestionId']?>" name="content" style="width: 50%; height: 250px;"></textarea><br>
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

						<div id="answers" style="width: auto;">
							<?php
							$query = "SELECT * FROM answer JOIN users USING(UserId) WHERE QuestionId = :questionid AND AnswerId = (SELECT Selected FROM question WHERE QuestionId = :questionid)";
							$statement = $db->prepare($query);
							$statement -> bindValue(":questionid", $question['QuestionId']);
							$statement -> execute(); 
							$answer = $statement->fetch();
							?>
							<?php if ($answer != null): ?>
								<?php $answerPic = 'images/users/'.$answer["ProfilePicURL"] ?>
								<div>
									<img class="answerPic" src=<?= $answerPic ?> alt="profile picture" onerror="this.onerror=null; this.src='images/users/default.jpg';" width="75" height="75">
									<div class="answer">

										<h3><a href="#"><?= $answer['FName'].' '.$answer['LName'] ?></a></h3>
										<img src="images/check.png" alt="chosen" width="35" height="35">

										<p><?= $answer['Content'] ?></p>
									</div>
								</div>
							<?php endif ?>
						</div>
					</div>
					<br>
				<?php endforeach ?>
			</div>
		</div>
	</div>
</div>
</body>
</html>
<script>
	$('iframe').css('height','100%');
	$('iframe').css('width','100%');
</script>