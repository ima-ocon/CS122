<html>
<body>
<?php

/*$servername = "localhost";
    		$username = "root";
    		$password = "";
    		$db = "dist";*/

        $url = parse_url(getenv("CLEARDB_DATABASE_URL"));

        $servername = $url["host"];
        $username = $url["user"];
        $password = $url["pass"];
        $db = substr($url["path"], 1);

$conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$tables = array('user_account', 'warehouse_staff', 'agent', 'client', 'supplier', 'itemtypes', 'item',
'invoice', 'delivery_content', 'issuance_content', 'discountrates', 'delivery', 'item_issuance', 'invoice_content',
'item_transfer', 'item_return', 'transfer_content', 'return_content');
$numTables = count($tables);

for ($i = 0; $i < $numTables; $i++) {
    printTable($conn, $tables[$i]);
}

				function printTable($conn, $table) {
          $statement = $conn->prepare("DESCRIBE " . $table);
          $statement->execute();
          $table_fields = $statement->fetchAll(PDO::FETCH_COLUMN);
          $numColumns = count($table_fields);
?>
          <h2><?php echo $table ?></h2>
          <table border="1" style="width:100%">
          <thead><tr>
          <?php for ($i = 0; $i < $numColumns; $i++) {?>
            <th> <?php echo $table_fields[$i] ?></th> <?php ;
          }?>
        </tr></thead>

        <?php $sql = "SELECT * FROM " . $table;
        $statement = $conn->prepare($sql);
        $statement->execute();

        while( $row = $statement->fetch(PDO::FETCH_ASSOC) ) { ?>
            <tr>
              <?php for ($i = 0; $i < $numColumns; $i++) {?>
                <td> <?php echo $row[$table_fields[$i]] ?></td> <?php ;
              }?>
            </tr>
        <?php } ?>
      </table>
      <?php }?>
</body>
</html>
