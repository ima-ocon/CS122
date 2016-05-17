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

			printWarehouseStaff($conn);
			printAccounts($conn);

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
	    			$sql = 'SELECT userID AS userID, warehouse_staff.s_firstname AS firstName, warehouse_staff.s_lastname AS lastName, user_account.staffID AS staffID, user_account.upassword AS password FROM user_account, warehouse_staff WHERE user_account.staffID = warehouse_staff.staffID';
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
    						<td><?php echo $row['firstName']; ?></td>
    						<td><?php echo $row['lastName']; ?></td>
    						<td><?php echo $row['staffID']; ?></td>
    						<td><?php echo $row['password']; ?></td>
							</tr>
					<?php
				} ?>
				</table>
				<?php
				$statement = null;
			 }
?>
</body>
</html>
