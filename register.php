<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_employee_id = $_POST['employee_id'];
    $user_password = $_POST['password'];

		$servername = "localhost";
		$username = "root";
		$password = "";
		$db = "dist";

/*		$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

		$servername = $url["host"];
		$username = $url["user"];
		$password = $url["pass"];
		$db = substr($url["path"], 1);*/

			function checkIfValueInColumn($conn, $table, $column, $value) {
					$sql = 'SELECT * FROM '. $table . ' WHERE ' . $column . ' = ' . $value;
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


        	function makeNewAccount($conn, $user_employee_id, $user_password) {
        		$sql = "INSERT INTO user_account (staffID, upassword) VALUES
        		(:staffID, :upassword)";
        		$statement = $conn->prepare($sql);

        		$statement->execute(array(
        		"staffID" => $user_employee_id,
        		"upassword" => $user_password
        		));

        		$affected_rows = $statement->rowCount();
        		if ($affected_rows > 0)
        			return true;
        		else
        			return false;
        	}
	try {
		$conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		if (checkIfValueInColumn($conn, 'warehouse_staff', 'staffID', $user_employee_id)) {
			echo "Staff ID exists!\n";

			if (!checkIfValueInColumn($conn, 'user_account', 'staffID', $user_employee_id)) {
				$_SESSION['staffID'] = $user_employee_id;
				$_SESSION['password'] = $user_password;

				makeNewAccount($conn, $user_employee_id, $user_password);

				header("location: home.php");
			}
			else
				echo "Employee already has an account!\n";
		}
		else
			echo "Staff ID doesn\'t exist D:\n";
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
	<div id="register-div">
		<div>
			<img id="register-logo" src="assets/images/logo.png" />
			<span>Create an account</span>
			<form id="register-form" method="POST" action="">
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
