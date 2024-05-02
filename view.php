<?php
	include('config.php');

	include('db.php');

		$selected_color = $_POST['colors'];
		$limit = 500;

	if(isset($_POST['colors'])){

        $sql = 'SELECT * FROM sales WHERE Color = ? LIMIT ?';

		$stmt = $pdo->prepare($sql); 

		// Execute the prepared statement with the parameter $color
		$stmt->execute([$selected_color, $limit]);
		$recordCount = $stmt->rowCount();

		// Fetch all the rows returned by the query
		$sales = $stmt->fetchAll();
		
	}

?>

<!DOCTYPE html>
<html>
	<?php include('header.php'); ?>
	<style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
<body>
<nav >
    <div class="center">
		<a href="index.php" >CompanyABC</a><br>
      <a class="btn btn-default" href="index.php" >Home</a>
    </div>
  </nav>
	<br>
	<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
	  <label for="colors">Choose a color to filter:</label>
	  <select name="colors" id="colors">
	    <option value="black">Black</option>
	    <option value="blue">Blue</option>
	    <option value="green">Green</option>
	    <option value="purple">Purple</option>
	    <option value="red">Red</option>
	    <option value="white">White</option>
	    <option value="yellow">Yellow</option>
	  </select>
	  <br><br>
	  <input type="submit" value="Filter">
	</form>
	
	
</body>
<?php if(isset($sales)): ?>
	<?php echo 'Number of Records: ' . $recordCount . '<br>';
			echo 'Displaying: ' . $selected_color ?>
        <table>
            <tr>
                <th>Order Number</th>
                <th>Item Number</th>
                <th>Description</th>
                <th>Size</th>
				<th>Price</th>
            </tr>
            <?php foreach($sales as $sale): ?>
                <tr>
                    <td><?php echo $sale->OrderNumber; ?></td>
                    <td><?php echo $sale->ItemNumber; ?></td>
                    <td><?php echo $sale->Description; ?></td>
					<td><?php echo $sale->Size; ?></td>
                    <td><?php echo $sale->Price; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
	<?php include('footer.php'); ?>
</html>
