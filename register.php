<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="styles/menu.css">
	<script
	src="https://code.jquery.com/jquery-3.3.1.min.js"
	integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
	crossorigin="anonymous"></script>
	<script type="text/javascript" src="scripts/imagePreview.js"></script>
	<title>Register</title>
</head>
<body>
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
			<button type="reset" onclick="hideImage();">Reset</button>
		</fieldset>
	</form>
</body>
</html>


<