<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />

	<title>AMDG</title>
	<link rel="icon" href="favicon.ico" />
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="assets/css/reset.css" />
	<link rel="stylesheet" href="assets/css/main.css" />

	<script type='text/javascript' src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	<script type='text/javascript' src="assets/js/app.js"></script>
</head>

<body>
	<?php
		$user_employee_id = $_SESSION['staffID'];
		$user_password = $_SESSION['password'];

		$servername = "localhost";
		$username = "root";
		$password = "";
		$db = "dist";

		try {
			$conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
		// set the PDO error mode to exception
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch(PDOException $e)
		{
			echo "Error: " . $e->getMessage();
		}


		?>
	<nav id="home-nav">
		<ul>
			<li>
				<a href="index.html" id="home-logo"></a>
			</li>
			<li>
				<div id="user-div">
					<a href="login.html">
						<div id="user-dp"></div>
						<div id="user-div-text">
							<span id="user-name">Miguel Galace</span>
							<span id="user-id"><?php echo $_SESSION['staffID'] ?></span>
						</div>
					</a>
				</div>
			</li>
			<li>
				<a class="nav-link dashboard-section" id="nav-dashboard">
					<div id="home-nav-marker"></div>Dashboard
				</a>
			</li>
			<li>
				<span class="home-nav-heading">Inventory</span>
				<ul>
					<li><a class="nav-link deliveries-section">Deliveries</a></li>
					<li><a class="nav-link issuances-section">Item issuances</a></li>
					<li><a class="nav-link transfers-section">Item transfers</a></li>
					<li><a class="nav-link returns-section">Item returns</a></li>
				</ul>
			</li>
			<li>
				<span class="home-nav-heading">Transactions</span>
				<ul>
					<li><a class="nav-link invoices-section">Sales invoices</a></li>
				</ul>
			</li>
		<ul>
	</nav>

	<div id="home-content">
		<div id="focused-card"></div>
		<div class="fab hoverable" id="main-fab">
			<div id="fab-dial">
				<div class="fab sub-fab hoverable" id="add-fab">
					<div class="add-icon">
						<div></div>
						<div></div>
					</div>
				</div>
				<div class="fab sub-fab hoverable" id="search-fab">
					<i class="material-icons">search</i>
				</div>
			</div>
			<div class="add-icon">
				<div></div>
				<div></div>
			</div>
		</div>
		<section class="home-section dashboard-section">
			<div id="overview">
				<span class="section-heading">This week</span>
				<div id="overview-marker"></div>
				<div id="overview-text">
					<div id="overview-inventory">
						<div id="inventory-total">67 items</div>
						<div id="inventory-heading">Inventory</div>
					</div>
					<div class="overview-small">
						<div class="overview-small-total">111 sales</div>
						<div class="section-small-heading">Transactions</div>
					</div>
					<div class="overview-small">
						<div class="overview-small-total">P74,000</div>
						<div class="section-small-heading">Profit</div>
					</div>
				</div>
			</div>
			<div class="dashboard-feed">
				<span class="section-heading">Recent</span>
				<div class="feed-card hoverable">
					<span class="feed-card-title">Item Return Form</span>
					<span class="feed-card-date">20/12/12</span>
					<span class="feed-card-id">#2385937396</span>
					<span class="feed-card-info">
						Batch: 201212150012<br />
						Agent: Pride, Brenda Kimberly<br />
						Client: ABS-CBN<br />
					</span>
				</div>
				<div class="feed-card hoverable">
					<span class="feed-card-title">Sales Invoice</span>
					<span class="feed-card-date">17/12/12</span>
					<span class="feed-card-id">#98806</span>
					<span class="feed-card-info">
						Agent: Pride, Brenda Kimberly<br />
						Client: ABS-CBN<br />
						Total: P18,700.00
					</span>
				</div>
				<div class="feed-card hoverable">
					<span class="feed-card-title">Item Issuance Form</span>
					<span class="feed-card-date">15/12/12</span>
					<span class="feed-card-id">#6285046255</span>
					<span class="feed-card-info">
						Batch: 201212150012<br />
						Agent: Pride, Brenda Kimberly<br />
						Client: ABS-CBN<br />
						Issuer: Smith, Joana
					</span>
				</div>
				<div class="feed-card hoverable">
					<span class="feed-card-title">Item Transfer Form</span>
					<span class="feed-card-date">15/12/12</span>
					<span class="feed-card-id">#5395726206</span>
					<span class="feed-card-info">
						From: <span class="transfer-from-name">Pride, Brenda Kimberly</span><br />
						<span class="transfer-from-batch">201212150012</span><br />
						To: <span class="transfer-to-name">Worth, Lydia</span><br />
						<span class="transfer-to-batch">201212150033</span>
					</span>
				</div>
				<div class="feed-card hoverable">
					<span class="feed-card-title">Delivery Receipt</span>
					<span class="feed-card-date">13/12/12</span>
					<span class="feed-card-id">#3658365721</span>
					<span class="feed-card-info">
						Delivery: 201212130100<br />
						Time: 9:00 AM<br />
						Receiver: Hedge, Jerry<br />
						Supplier: Columbia
					</span>
				</div>
			</div>
		</section>

		<section class="home-section deliveries-section">
			<div class="feedlist-marker"></div>
			<div class="feedlist-heading">
				<div class="feedlist-title">Deliveries</div>
				<div class="section-small-heading">Inventory</div>
			</div>
			<div class="feedlist">
				<?php
				echo $user_employee_id;
				$sql = 'SELECT delivery.dbatchID AS dbatchID, delivery.ddate AS ddate,
					delivery.dtime AS dtime, CONCAT(warehouse_staff.s_lastname, \', \', warehouse_staff.s_firstname) AS receiver,
					supplier.s_name AS supplier FROM delivery, warehouse_staff, supplier
						WHERE delivery.staffID = warehouse_staff.staffID AND delivery.supplierno = supplier.supplierno ORDER BY YEAR(delivery.ddate) DESC, MONTH(delivery.ddate) DESC, DAY(delivery.ddate) DESC';
        $statement = $conn->prepare($sql);
        $statement->execute();

				//, CONCAT(warehouse_staff.s_lastname, ', ', warehouse_staff.s_firstname) AS receiver

				while( $row = $statement->fetch(PDO::FETCH_ASSOC) ) { ?>
					<div class="feed-card hoverable">
						<span class="feed-card-id"><?php echo '#' . $row['dbatchID']?></span>
						<span class="feed-card-date"><?php echo $row['ddate']?></span>
						<span class="feed-card-info">
							Delivery: <?php echo $row['ddate'] . $row['dtime']?> <br />
							Time: <?php echo $row['dtime']?><br />
							Receiver: <?php echo $row['receiver']?><br />
							Supplier: <?php echo $row['supplier']?>
						</span>
					</div>
				<?php }?>
			</div>
		</section>

		<section class="home-section issuances-section">
			<div class="feedlist-marker"></div>
			<div class="feedlist-heading">
				<div class="feedlist-title">Item issuances</div>
				<div class="section-small-heading">Inventory</div>
			</div>
			<div class="feedlist">
				<?php
				$sql = 'SELECT item_issuance.ibatchID AS ibatchID, item_issuance.i_date AS i_date,
					item_issuance.i_time AS i_time, CONCAT(agent.alastname, \', \', agent.afirstname) AS agent,
					CONCAT(warehouse_staff.s_lastname, \', \', warehouse_staff.s_firstname) AS issuer,
					client.c_name AS client
					 FROM item_issuance, agent, warehouse_staff, client
					 WHERE item_issuance.agentno = agent.agentno AND item_issuance.staffID = warehouse_staff.staffID
					 AND agent.clientno = client.clientno
					 ORDER BY YEAR(item_issuance.i_date) DESC, MONTH(item_issuance.i_date) DESC, DAY(item_issuance.i_date) DESC';
					 	$statement = $conn->prepare($sql);
        $statement->execute();

				while( $row = $statement->fetch(PDO::FETCH_ASSOC) ) { ?>
					<div class="feed-card hoverable">
						<span class="feed-card-id">#<?php echo $row['ibatchID']?></span>
						<span class="feed-card-date"><?php echo $row['i_date']?></span>
						<span class="feed-card-info">
							Batch: <?php echo $row['ibatchID'] . $row['i_date']?> <br />
							Agent: <?php echo $row['agent']?><br />
							Client: <?php echo $row['client']?><br />
							Issuer: <?php echo $row['issuer']?>
						</span>
					</div>
					<?php }?>
				</div>
		</section>

		<section class="home-section transfers-section">
			<div class="feedlist-marker"></div>
			<div class="feedlist-heading">
				<div class="feedlist-title">Item transfers</div>
				<div class="section-small-heading">Inventory</div>
			</div>
			<?php
			$sql = 'SELECT item_transfer.itbatchID AS itbatchID, item_transfer.itdate AS itdate, item_transfer.frombatchID AS frombatchID,
				item_transfer.tobatchID, CONCAT(a.alastname, \', \', a.afirstname) AS sender, CONCAT(b.alastname, \', \', b.afirstname) AS receiver
				FROM item_transfer, item_issuance AS send_item_issuance, item_issuance AS receive_item_issuance, agent AS a, agent AS b
				WHERE item_transfer.frombatchID = send_item_issuance.ibatchID AND send_item_issuance.agentno = a.agentno AND
				item_transfer.tobatchID = receive_item_issuance.ibatchID AND receive_item_issuance.agentno = b.agentno';
				 /*
				 WHERE item_issuance.agentno = agent.agentno AND item_issuance.staffID = warehouse_staff.staffID
				 AND agent.clientno = client.clientno
				 ORDER BY YEAR(item_issuance.i_date) DESC, MONTH(item_issuance.i_date) DESC, DAY(item_issuance.i_date) DESC';

 			  item_issuance.i_date AS i_date,
 				item_issuance.i_time AS i_time, CONCAT(agent.alastname, \', \', agent.afirstname) AS agent,
 				CONCAT(warehouse_staff.s_lastname, \', \', warehouse_staff.s_firstname) AS issuer,
 				client.c_name AS client
*/					$statement = $conn->prepare($sql);
			$statement->execute();?>

			<div class="feedlist">
				<?php while( $row = $statement->fetch(PDO::FETCH_ASSOC) ) { ?>
				<div class="feed-card hoverable">
					<span class="feed-card-id">#<?php echo $row['itbatchID']?></span>
					<span class="feed-card-date"><?php echo $row['itbatchID']?></span>
					<span class="feed-card-info">
						From: <span class="transfer-from-name"><?php echo $row['sender']?></span><br />
						<span class="transfer-from-batch"><?php echo $row['frombatchID']?></span><br />
						To: <span class="transfer-to-name"><?php echo $row['receiver']?></span><br />
						<span class="transfer-to-batch"><?php echo $row['tobatchID']?></span>
					</span>
				</div>
				<?php }?>
			</div>
		</section>

		<section class="home-section returns-section">
			<div class="feedlist-marker"></div>
			<div class="feedlist-heading">
				<div class="feedlist-title">Item returns</div>
				<div class="section-small-heading">Inventory</div>
			</div>
			<div class="feedlist">
				<div class="feed-card hoverable">
					<span class="feed-card-id">#2385937396</span>
					<span class="feed-card-date">20/12/12</span>
					<span class="feed-card-info">
						Batch: 201212150012<br />
						Agent: Pride, Brenda Kimberly<br />
						Client: ABS-CBN<br />
					</span>
				</div>
				<div class="feed-card hoverable">
					<span class="feed-card-id">#2385937396</span>
					<span class="feed-card-date">20/12/12</span>
					<span class="feed-card-info">
						Batch: 201212150012<br />
						Agent: Pride, Brenda Kimberly<br />
						Client: ABS-CBN<br />
					</span>
				</div>
				<div class="feed-card hoverable">
					<span class="feed-card-id">#2385937396</span>
					<span class="feed-card-date">20/12/12</span>
					<span class="feed-card-info">
						Batch: 201212150012<br />
						Agent: Pride, Brenda Kimberly<br />
						Client: ABS-CBN<br />
					</span>
				</div>
			</div>
		</section>

		<section class="home-section invoices-section">
			<div class="feedlist-marker"></div>
			<div class="feedlist-heading">
				<div class="feedlist-title">Sales invoices</div>
				<div class="section-small-heading">Transactions</div>
			</div>
			<div class="feedlist">
				<div class="feed-card hoverable">
					<span class="feed-card-id">#98806</span>
					<span class="feed-card-date">17/12/12</span>
					<span class="feed-card-info">
						Agent: Pride, Brenda Kimberly<br />
						Client: ABS-CBN<br />
						Total: P18,700.00
					</span>
				</div>
				<div class="feed-card hoverable">
					<span class="feed-card-id">#98806</span>
					<span class="feed-card-date">17/12/12</span>
					<span class="feed-card-info">
						Agent: Pride, Brenda Kimberly<br />
						Client: ABS-CBN<br />
						Total: P18,700.00
					</span>
				</div>
				<div class="feed-card hoverable">
					<span class="feed-card-id">#98806</span>
					<span class="feed-card-date">17/12/12</span>
					<span class="feed-card-info">
						Agent: Pride, Brenda Kimberly<br />
						Client: ABS-CBN<br />
						Total: P18,700.00
					</span>
				</div>
			</div>
		</section>
	</div>
</body>
</html>
