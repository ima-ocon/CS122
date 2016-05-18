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
    		$db = "dist";*/

//$conn = new PDO("mysql:host=$servername", $username, $password);
$conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//$sql = file_get_contents('tables.sql');

//$statement = $conn->exec($sql);

//exec_sql_from_file('tables.sql', $conn);
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
		<nav id="claim-nav">
			<p><a id="database-link" href="database_viewer.php">{View database}</a></p>
			<ul>
				<li><img id="claim-logo" src="assets/images/logo.png" /></li>
				<li><a id="login-link" href="login.php">Log in</a></li>
			</ul>
		</nav>
		<h1>Track product inventory and sales.</h1>
		<h2>Easily access and manage the <span id="amdg-text">AMDG</span> business database.</h2>
		<a class="btn" id="action-btn" href="register.php">Get started</a>
		<small>&copy; 2016 Argon Marcus Distribution Group</small>
	</header>
</body>
</html>
