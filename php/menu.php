<?php 
    $userPic = (is_null($userPic) ? "Login" : $UserId);
    $userId = (is_null($userId) ? "Login" : $UserId);
?>

<ul class="mainMenu decor3_1">
    <li><a href="index.php">Home</a></li>
    <li class="separator"></li>
    <li><a href="questions.php">Ask</a>
        <div class="drop decor3_2" style="width: 100px;">
            <div class="left">
                <a href="questions.php?new">New</a><br />
                <a href="questions.php?my">My Questions</a><br />
            </div>
            <div style="clear: both;"></div>
        </div>
    </li>
    <li class="separator"></li>
    <li><a href="answers.php">Answer</a>
        <div class="drop decor3_2" style="width: 100px;">
            <div class="left">
                <a href="answers.php?course">Answer by Course</a><br />
                <a href="answers.php?tag">Answer by Tag</a><br />
                <a href="answers.php?recent">Recent Questions</a><br />
                <a href="answers.php?my">My Answers</a>
            </div>
            <div style="clear: both;"></div>
        </div>
    </li>
    <li class="separator"></li>
    <li><a href="browes.php">Browse</a>
        <div class="drop decor3_2" style="width: 100px;">
            <div class="left">
                <a href="search.php">Search</a><br />
                <a href="browse.php?course">Browse by Course</a><br />
                <a href="browse.php?tag">Browse by Tag</a><br />
            </div>
            <div style="clear: both;"></div>
        </div>
    </li>
    <li class="separator"></li>
    <li><a href="login.php"><?= $userId ?></a>
        <div class="drop decor3_2 dropToLeft" style="width: 460px;">
            <img src=<?= $userPic ?> alt="profile picture" style="float:left; width:200px; height:200px;margin:10px 80px 10px 40px;" />
            <div class="left">
                <b><?= $userId ?></b>
                <div>
                    <a href="profile.php">Profile</a><br />
                    <a href="resetPassword.php">Reset Password</a><br />
                    <a href="logout.php">Logout</a>
                </div>
            </div>
        </div>
    </li>
</ul>