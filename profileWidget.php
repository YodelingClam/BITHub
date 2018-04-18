<link rel="stylesheet" type="text/css" href="styles/profileWidget.css">
<script type="text/javascript" src="scripts/profileWidget.js"></script>
<div class="profile-box big">
  <figure class="profile-header">
    <div class="profile-img" style="position: relative;" onmouseenter="$('#clickToChange').show();" onmouseleave="$('#clickToChange').hide();">
      <span><img id="clickToChange" src="images/users/clickToChange.jpg" alt="wtf" onclick="$('#changePic').click()" ><img class="profile-avatar" src=<?= $userPic ?> alt="profile picture" onerror="this.onerror=null; this.src='images/users/default.jpg';" width="150" height="150"></span>
    </div>
    <figcaption class="profile-name"><?= $_SESSION["userName"].' '.$_SESSION["userLName"] ?></figcaption>
  </figure>
  <p class="profile-detail">
   <span id="emailLabel" class="profile-label">Email:</span><span id="emailEdit" class="profile-value" onclick="displayEdit('email')"><?= $_SESSION['userEmail'] ?></span>
 </p>
 <p class="profile-detail">
  <span class="profile-label">Questions:</span><span class="profile-value"><?= $_SESSION['questions'] ?></span>
</p>
<p class="profile-detail">
  <span class="profile-label">Answers:</span><span class="profile-value"><?= $_SESSION['answers'] ?></span>
</p>
<p class="profile-detail">
  <span class="profile-value" style="float: right; "><a href="logout.php">Logout</a></span>
</p>
</div>
<form enctype="multipart/form-data" style="display: none;">
  <input id="changePic" type="file" name="image" accept="image/*" style="display: none;" onchange="updateImage();" >
</form>