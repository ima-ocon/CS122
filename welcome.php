<?php
session_start();
?>
<html>
<body>
<p>Welcome!</p>
<?php
	    	$servername = "localhost";
    		$username = "root";
    		$password = "";
    		$db = "dist";

    		echo $_SESSION['staffID'];

    		try {
        	$conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
        	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        	makeNewAccount($conn, $_SESSION['staffID'], $_SESSION['password']);

	        $conn = null;
        }
    		catch(PDOException $e)
        {
        	echo "Error: " . $e->getMessage();
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

?>
</body>
</html>
