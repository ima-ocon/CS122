<?php
session_start()
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />

	<title>AMDG</title>
	<link rel="icon" href="favicon.ico" />
	<link rel="stylesheet" href="assets/css/reset.css" />
	<link rel="stylesheet" href="assets/css/main.css" />
	<link rel="stylesheet" href="assets/css/extra.css" />
</head>

<body>
	<div id="register-div">
		<div>
			<img id="register-logo" src="assets/images/logo.png" />
      <?php
        $user_employee_id = $_POST['employee_id'];
        $user_password = $_POST['password'];

    		$servername = "localhost";
    		$username = "root";
    		$password = "";
    		$db = "dist";

    		try {
        	$conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
        // set the PDO error mode to exception
        	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

					if (checkIfValueInColumn($conn, 'warehouse_staff', 'staffID', $user_employee_id)) {
						echo "Staff ID exists!\n";

						if (!checkIfValueInColumn($conn, 'user_account', 'staffID', $user_employee_id)) {
							if (makeNewAccount($conn, $user_employee_id, $user_password))
								echo "Successfully made an account!\n";
							else
								echo "Internal error making an account!\n";
						}
						else
							echo "Employee already has an account!\n";
					}
					else
						echo "Staff ID doesn\'t exist D:\n";


					printWarehouseStaff($conn);
					printAccounts($conn);

    			//insert
    			/*$statement = $conn->prepare("INSERT INTO warehouse_staff (s_lastname, s_firstname, s_MI, s_address, s_contactno) VALUES
    			(:lname, :fname, :mi, :address, :contactno)"); //'Galace', 'Miguel', 'N.', 'Quezon City', '09171234567');");

    			$statement->execute(array(
        	"lname" => "Galace",
        	"fname" => "Miguel",
        	"mi" => "N.",
    			"address" => "Quezon City",
        	"contactno" => "09171234567"
    			));

    			$affected_rows = $statement->rowCount();
    			echo $affected_rows;*/

          $conn = null;
        }
    		catch(PDOException $e)
        {
        	echo "Error: " . $e->getMessage();
        }

				function printWarehouseStaff($conn) {
    			$sql = 'SELECT * FROM warehouse_staff';
					$statement = $conn->prepare($sql);
					$statement->execute();?>
					<p class="table_title">WAREHOUSE STAFF</p>
					<table border="1" style="width:100%">
						<thead> <tr>
							<th>Staff ID</th>
							<th>Last Name</th>
							<th>M.I.</th>
							<th>First Name</th>
							<th>Address</th>
							<th>Contact No.</th>
						</tr> </thead>
					<?php while( $row = $statement->fetch(PDO::FETCH_ASSOC) ) { ?>
							<tr>
    						<td><?php echo $row['staffID']; ?></td>
    						<td><?php echo $row['s_lastname']; ?></td>
    						<td><?php echo $row['s_MI']; ?></td>
    						<td><?php echo $row['s_firstname']; ?></td>
    						<td><?php echo $row['s_address']; ?></td>
								<td><?php echo $row['s_contactno']; ?></td>
							</tr>
					<?php } ?>
					</table>
					<?php
					$statement = null;
				}

				function printAccounts($conn) {
    			$sql = 'SELECT * FROM user_account';
					$statement = $conn->prepare($sql);
					$statement->execute();?>

					<p class="table_title">USER ACCOUNTS</p>
					<p class="table_comment">First name and last name from warehouse_staff table</p>
					<table>
						<thead> <tr>
							<th>User ID</th>
							<th>Last Name</th>
							<th>First Name</th>
							<th>Staff ID</th>
							<th>Password</th>
						</tr> </thead>
					<?php while( $row = $statement->fetch(PDO::FETCH_ASSOC) ) { ?>
							<tr>
    						<td><?php echo $row['userID']; ?></td>

								<?php $sql = 'SELECT s_lastname FROM warehouse_staff WHERE staffID = '. $row['staffID'];
								$statement = $conn->query($sql);
								$ulastname = $statement->fetchColumn();?>
    						<td><?php echo $ulastname; ?></td>

								<?php $sql = 'SELECT s_firstname FROM warehouse_staff WHERE staffID = ' . $row['staffID'];
								$statement = $conn->query($sql);
								$ufirstname = $statement->fetchColumn();?>
    						<td><?php echo $ufirstname; ?></td>

    						<td><?php echo $row['staffID']; ?></td>
    						<td><?php echo $row['upassword']; ?></td>
							</tr>
					<?php
				} ?>
				</table>
				<?php
				$statement = null;
			 }

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
				?>
		</div>
	</div>
</body>
</html>
