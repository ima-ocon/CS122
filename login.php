<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $enteredID = $_POST['enteredID'];
  $enteredPassword = $_POST['enteredPassword'];

/*	$servername = "localhost";
	$username = "root";
	$password = "";
	$db = "dist";*/

  $url = parse_url(getenv("CLEARDB_DATABASE_URL"));

  $servername = $url["host"];
  $username = $url["user"];
  $password = $url["pass"];
  $db = substr($url["path"], 1);


				function checkUserLogin($conn, $enteredID, $enteredPassword) {
					$sql = 'SELECT * FROM user_account WHERE staffID = ' . $enteredID . ' AND upassword = \'' . $enteredPassword . '\'';
					$statement = $conn->prepare($sql);
					$statement->execute();

					$count = $statement->rowCount();

					if ($count > 0) {
						return true;
					 }
						else {
						return false;
				 	}
					$statement = null;
				}
	try {
		$conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		if (checkUserLogin($conn, $enteredID, $enteredPassword)) {
			echo "User login successful!\n";

			$_SESSION['staffID'] = $enteredID;
			$_SESSION['password'] = $enteredPassword;
			header("location: home.php");
		}
		else
			echo "Wrong username or password:\n";

	    $conn = null;
	}
	catch(PDOException $e)
	{
		echo "Error: " . $e->getMessage();
	}
}
?>

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
	<div id="login-div">
		<div>
			<img id="login-logo" src="assets/images/logo.png" />
			<form id="login-form" method="POST" action="">
				<input class="login-form-input" name="enteredID" type="text" placeholder="Employee ID" />
				<input class="login-form-input" name="enteredPassword" type="password" placeholder="Password" />
				<input class="btn login-form-input" id="login-submit" type="submit" value="Log in" />
			</form>

			<a href="register.html">Create an account</a>
		</div>
	</div>
</body>
</html>
