<?php 
if (!isset($_SESSION)) {
    session_start();
}
require "vendor/autoload.php";
?>
<script src="https://cdn.ckeditor.com/ckeditor5/1.0.0-beta.1/classic/ckeditor.js"></script>
<link rel="stylesheet" type="text/css" href="styles/menu.css"/>
<script
src="https://code.jquery.com/jquery-3.3.1.min.js"
integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
crossorigin="anonymous"></script>
<script type="text/javascript" src="scripts/register.js"></script>

<?php if (isset($_GET['invalidLogin'])) : ?>
    <script type='text/javascript'>alert('Invalid email or password!');</script>
<?php endif ?>
<ul class="mainMenu decor3_1">
    <li><a href="index.php">Home</a></li>
    <?php if (isset($_SESSION['userId'])): ?>
        <li class="separator"></li>
        <li><a href="newPost.php">Ask</a>
            <!-- <div class="drop decor3_2">
                <div class="left">
                    <a href="newPost.php">New</a><br />
                    <a href="questions.php?my">My Questions</a><br />
                </div>
                <div style="clear: both;"></div>
            </div> -->
        </li>
        <!-- <li class="separator"></li> -->
        <!-- <li><a href="answers.php?search=recent">Answer</a> -->
            <!-- <div class="drop decor3_2" >
                <div class="left">
                    <a href="answers.php?search=course">Answer by Course</a><br />
                    <a href="answers.php?search=tag">Answer by Tag</a><br />
                    <a href="answers.php?search=recent">Recent Questions</a><br />
                    <a href="answers.php?search=my">My Answers</a>
                </div>
                <div style="clear: both;"></div>
            </div> -->
        <!-- </li> -->
    <?php endif ?>
    <li class="separator"></li>
    <li><a href="#">Browse</a>
        <div class="drop decor3_2" >
            <div class="left">
                <a href="browse.php?type=search&by=">Search</a><br />
                <a href="browse.php?type=course">Browse by Course</a><br />
                <!-- <a href="browse.php?type=tag">Browse by Tag</a><br /> -->
            </div>
            <div style="clear: both;"></div>
        </div>
    </li>
    <?php if (!isset($_SESSION['userId'])): ?>
        <li class="separator"></li>
        <li>
            <button onclick="myFunction()">Register</button>
        </li>
    <?php endif ?>
    <li class="separator"></li> 
    <?php $userId = (isset($_SESSION['userName']) ?  '<a href="#">'.$_SESSION["userName"].'</a>' : '<form action="login.php" method="post"><button type="submit">Login</button></li><li><input type="text" placeholder="Email" name="username" required><input type="password" placeholder="Password" name="password" required></li></form><form action="register.php" method="post"></form>' ) ?>
    <li><?= $userId ?></a>
        <?php if(isset($_SESSION['userName'])) : ?>
            <?php $userPic = $_SESSION['userPic']?>
            <div class="drop decor3_2 dropToLeft" style="width: auto;">
                <?php include 'profileWidget.php'; ?>
            </div>
        <?php endif ?>
    </li>
</ul>
<?php if (!isset($_SESSION['userId'])): ?>
    <div id="my-div" style="display:none;">
        <script type="text/javascript" src="scripts/imagePreview.js"></script>
        <form id="register" method="post" action="registerData.php" enctype="multipart/form-data">
            <fieldset>
                <label for="email">Email:</label>
                <input id="email" name="email" type="email" placeholder="you@site.com" autofocus required/>
                <br>
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required />
                <br>
                <label for="password2">Confirm Password:</label>
                <input type="password" name="password2" id="password2" required />
                <br>
                <label for="firstname">First Name:</label>
                <input id="firstname" name="firstname" type="text" placeholder="First Name" required/>
                <br>
                <label for="lastname">First Name:</label>
                <input id="lastname" name="lastname" type="text" placeholder="Last Name" required/>
                <br>
                <label for="ImgControl">Profile Picture</label>
                <input id="ImgControl" type="file" name="image" accept="image/*">
                <div id="ImgContain" style="display: none; width: 300px; height: 300px;"><img src="#" id="ImgPreview" alt="alt" style="display: none; width: 100%; height: 100%; object-fit: contain; /*magic*/"></div>
                <br>
                <button type="submit">Submit</button>
                <button type="reset" onclick="hideImage();document.getElementById('my-div').style.display = 'none';">Cancel</button>
            </fieldset>
        </form>
    </div>
<?php endif ?>
<div id="clear"> </div>