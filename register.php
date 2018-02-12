<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="styles/menu.css">
<!-- 	<script type="text/javascript" src="scripts/validate.js" ></script> -->
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
			<label for="image">Profile Picture</label>
			<input type="file" name="image" id="profilepic" accept="image/*">
			<br>
			<button type="submit">Submit</button>
			<button type="reset">Reset</button>
		</fieldset>
	</form>
</body>
</html>