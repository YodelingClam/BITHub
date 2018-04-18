<?php 
require 'connect.php';
$post = filter_var($_GET['post'], FILTER_VALIDATE_INT);
$query = "SELECT * FROM question JOIN users USING(UserId) JOIN course USING(CourseId) WHERE QuestionId = :questionid";
$statement = $db->prepare($query);
$statement -> bindValue(":questionid", $post);		
$statement -> execute(); 
$question = $statement->fetch();

?>
<!DOCTYPE html>
<html>
<head>
	<title>BITHub</title>
	<script src="https://cdn.ckeditor.com/ckeditor5/1.0.0-beta.1/classic/ckeditor.js"></script>
	<link rel="stylesheet" type="text/css" href="styles/browse.css">
</head>
<body>
	<?php include 'menu.php'; ?>
	<?php if (isset($_GET['edit'])): ?>
		<?php 
		$query = "SELECT * FROM course ORDER BY CourseAbv";
		$statement = $db->prepare($query);	
		$statement -> execute(); 
		$courses = $statement->fetchAll();
		?>
		<form method="post" action="updateQuestion.php">
			<input id="title" name="title" type="text" placeholder="Title of question" required autofocus/ value="<?= $question['Title'] ?>"><br>
			<textarea required id="editor" name="content" rows="10" cols="40" style="width: 100%;"><?= $question['Content'] ?></textarea><br>
			<label for="course">Course:</label>
			<select id="course" name="course">
				<?php foreach ($courses as $key => $value): ?>
					<option value="<?= $value['CourseId'] ?>" <?= $value['CourseId'] == $question['CourseId'] ? "Selected" : ""?>> <?= $value['CourseAbv'] .' - '. $value['CourseName']?></option>
				<?php endforeach ?>
				<input type="hidden" name="questionid" value="<?= $question['QuestionId'] ?>">
			</select>
			<button type="submit">Submit</button>
		</form>
		<script>
			ClassicEditor
			.create( document.querySelector( '#editor' ) )
			.catch( error => {
				console.error( error );
			} );
		</script>
	<?php else: ?>
		<div id="question">

			<div class="question">
				<?php $pic = 'images/users/'.$question["ProfilePicURL"] ?>
				<h1><?= $question['Title'] ?></h1>
				<h2><a onmouseenter="$('#profilePopup<?=$question['QuestionId']?>').show();" onmouseleave="$('#profilePopup<?=$question['QuestionId']?>').hide();" href="#"><?= $question['FName'].' '.$question['LName'] ?></a></h2>

				<div class="drop decor3_2 dropToLeft" style="width: auto;">
					<div id="profilePopup<?=$question['QuestionId']?>" style="width: auto; position: absolute; display: none; z-index: 1000; background-color: #333;" class="profile-box big whiteText">
						<figure class="profile-header">
							<div class="profile-img" style="position: relative;" onmouseenter="$('#clickToChange').show();" onmouseleave="$('#clickToChange').hide();">
								<span><img id="clickToChange" src="images/users/clickToChange.jpg" alt="wtf" onclick="$('#changePic').click()" ><img class="profile-avatar" src=<?= 'images/users/'.$question['ProfilePicURL'] ?> alt="profile picture" onerror="this.onerror=null; this.src='images/users/default.jpg';" width="150" height="150"></span>
							</div>
							<figcaption class="profile-name"><?= $question["FName"].' '.$question["LName"] ?></figcaption>
						</figure>
						<p class="profile-detail">
							<span class="profile-label">Questions:</span><span class="profile-value"><?= 0 ?></span>
						</p>
						<p class="profile-detail">
							<span class="profile-label">Answers:</span><span class="profile-value"><?= 0 ?></span>
						</p>
					</div>
				</div>

				<h4><?= $question['TimeStamp'] ?></h4>
				<h4>Course: <?= $question['CourseName'] ?></h4>
				<p><?= $question['Content'] ?></p>
				<?php if ((isset($_SESSION['admin']) && $_SESSION['admin'] > 0) || (isset($_SESSION['userId']) && $_SESSION['userId'] == $question['UserId'])): ?>
					<a href="question.php?post=<?= $question['QuestionId'] ?>&edit">Edit</a>
				<?php endif ?>
				<a href="#" onclick="$('#answer<?=$question['QuestionId']?>').show();">Answer</a>
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
		</div>
		<div id="answers">
			<?php
			$query = "SELECT * FROM answer JOIN users USING(UserId) WHERE QuestionId = :questionid ORDER BY TimeStamp";
			$statement = $db->prepare($query);
			$statement -> bindValue(":questionid", $question['QuestionId']);
			$statement -> execute(); 
			$answers = $statement->fetchAll();
			?>
			<?php foreach ($answers as $key => $answer): ?>
				<?php $answerPic = 'images/users/'.$answer["ProfilePicURL"] ?>
				<div>
					<img class="answerPic" src=<?= $answerPic ?> alt="profile picture" onerror="this.onerror=null; this.src='images/users/default.jpg';" width="75" height="75">
					<div class="answer">

						<h3><a onmouseenter="$('#profilePopup<?=$answer['AnswerId']?>').show();" onmouseleave="$('#profilePopup<?=$answer['AnswerId']?>').hide();" href="#"><?= $answer['FName'].' '.$answer['LName'] ?></a></h3>
						<?php if ($question['Selected'] == $answer['AnswerId']): ?>
							<img src="images/check.png" alt="chosen" width="35" height="35">
						<?php else: ?>
							<a href="#" onclick="
							$.ajax({
								async: true,
								url: 'select.php',
								type: 'POST',
								data: { answer: <?= $answer['AnswerId'] ?>,
										question: <?= $question['QuestionId'] ?> },
								success: function(){location.reload();} 
							});
							">Select</a>
						<?php endif ?>
						

						<div class="drop decor3_2 dropToLeft" style="width: auto;">
							<div id="profilePopup<?=$answer['AnswerId']?>" style="width: auto; position: absolute; display: none; z-index: 1000; background-color: #333;" class="profile-box big whiteText">
								<figure class="profile-header">
									<div class="profile-img" style="position: relative;" onmouseenter="$('#clickToChange').show();" onmouseleave="$('#clickToChange').hide();">
										<span><img class="profile-avatar" src=<?= 'images/users/'.$answer['ProfilePicURL'] ?> alt="profile picture" onerror="this.onerror=null; this.src='images/users/default.jpg';" width="150" height="150"></span>
									</div>
									<figcaption class="profile-name"><?= $answer["FName"].' '.$answer["LName"] ?></figcaption>
								</figure>
								<p class="profile-detail">
									<span class="profile-label">Questions:</span><span class="profile-value"><?= 0 ?></span>
								</p>
								<p class="profile-detail">
									<span class="profile-label">Answers:</span><span class="profile-value"><?= 0 ?></span>
								</p>
							</div>
						</div>

						<p><?= $answer['Content'] ?></p>
					</div>
				</div>
			<?php endforeach ?>
		</div>
	<?php endif ?>
</body>
</html>