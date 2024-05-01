
<?php
  // Create Connection
  include('config.php');
  $dsn='mysql:host=' . DB_HOST .'; dbname='. DB_NAME; 
	
  //Create a PDO instance - connection
  $pdo = new PDO($dsn, DB_USER, DB_PASS);
  $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
  $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

  // Check Connection using if statement 
  if(!$pdo){
    // Connection Failed
    echo 'Failed to connect to MySQL '. mysqli_connect_errno();
  } 
?>

