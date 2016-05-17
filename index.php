<?php
$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

$servername = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);

function exec_sql_from_file($path, PDO $pdo) {
    if (! preg_match_all("/('(\\\\.|.)*?'|[^;])+/s", file_get_contents($path), $m))
        return;

    foreach ($m[0] as $sql) {
        if (strlen(trim($sql)))
            $pdo->exec($sql);
    }
}

/*$servername = "localhost";
    		$username = "root";
    		$password = "";
    		$db = "dist";**/

$conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

exec_sql_from_file('tables.sql', $conn);

$sql = 'SELECT * FROM user_account';
$statement = $conn->prepare($sql);
$statement->execute();?>
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

			<td><?php echo $row['staffID']; ?></td>
			<td><?php echo $row['upassword']; ?></td>
		</tr>
<?php
} ?>
</table>

<?php try {
//    $conn->exec($sql);

/*		$sql = 'SELECT * FROM user_account';
		$statement = $conn->prepare($sql);
		$statement->execute();*/
		$row = $statement->fetch(PDO::FETCH_ASSOC);
		echo $row['userID'];
}
catch (PDOException $e)
{
    echo $e->getMessage();
    die();
}

//$qr = $conn->exec($sql);
//echo $qr;
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
	<header>
		<nav>
			<ul>
				<li><img id="claim-logo" src="assets/images/logo.png" /></li>
				<li><a id="login-link" href="login.html">Log in</a></li>
			</ul>
		</nav>
		<h1>Track product inventory and sales.</h1>
		<h2>Easily access and manage the <span id="amdg-text">AMDG</span> business database.</h2>
		<a class="btn" id="action-btn" href="register.php">Get started</a>
		<small>&copy; 2016 Argon Marcus Distribution Group</small>
	</header>
</body>
</html>
