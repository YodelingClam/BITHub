<?php 
session_start();
require 'connect.php';
$query = "SELECT * FROM question JOIN users USING(UserId) JOIN course USING(CourseId) WHERE CourseId = :courseid ORDER BY TimeStamp DESC";
$statement = $db->prepare($query);	
$statement -> bindValue(":courseid", $_POST['course']);	
$statement -> execute(); 
$questionsUtil = $statement->fetchAll();
?>
<?php foreach ($questionsUtil as $key => $question): ?>
	<div class="mainLi">
		<?php $pic = 'images/users/'.$question["ProfilePicURL"] ?>
		<a href="question.php?post=<?= $question['QuestionId'] ?>&course=<?= $question['CourseName'] ?>&title=<?= $question['Title'] ?>"><h1><?= $question['Title'] ?></h1></a>
		<h4><?= $question['TimeStamp'] ?></h4>
		<h4>Course: <?= $question['CourseName'] ?></h4>
		<p><?= $question['Content'] ?></p>
		<?php if ( (isset($_SESSION['admin']) && $_SESSION['admin'] > 0) || (isset($_SESSION['userId']) && $_SESSION['userId'] == $question['UserId'])): ?>
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
		<div id="answer<?=$question['QuestionId']?>" style="display: none;">
			<form action="newAnswer.php" method="post" style="width: 90%;">
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

		<div id="answers">
			<?php
			$query = "SELECT * FROM answer JOIN users USING(UserId) WHERE QuestionId = :questionid";
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


	</div>
<?php endforeach ?>