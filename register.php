<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />

	<title>AMDG</title>
	<link rel="icon" href="favicon.ico" />
	<link rel="stylesheet" href="assets/css/reset.css" />
	<link rel="stylesheet" href="assets/css/main.css" />
</head>

<body>
	<div id="register-div">
		<div>
			<img id="register-logo" src="assets/images/logo.png" />
			<span>Create an account</span>
			<form id="register-form" method="POST" action="register_result.php">
				<input class="register-form-input" name="firstname" id="firstname-input" type="text" placeholder="First name" />
				<input class="register-form-input" name="lastname" id="lastname-input" type="text" placeholder="Last name" />
				<input class="register-form-input" name="employee_id" type="text" placeholder="Employee ID" />
				<input class="register-form-input" name="password" type="password" placeholder="Password" />
				<input class="btn register-form-input" id="signup-submit" type="submit" value="Sign up" />
			</form>
		</div>
	</div>
	<?php
	?>
</body>
</html>
