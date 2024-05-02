<?php 

	include('db.php');
    
    if(isset($_POST['submit'])){
        $orderNumber = $_POST['orderToDelete'];
        $sql = 'DELETE FROM sales WHERE OrderNumber = :ordernumber';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['ordernumber'=> $orderNumber]);
      
    }

?>

<!DOCTYPE html>
<html>
	
	<?php include('header.php'); ?>
	<h4>Enter an order number to delete</h4>
    <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
				<input type="text" name="orderToDelete" value="<?php echo htmlspecialchars($orderNumber) ?>">
				<input type="submit" name="submit" value="Delete" class="btn brand z-depth-0">
                <a class="btn btn-default" href="index.php" role="button">Cancel</a>
	</form>

    <?php if(isset($_POST['submit'])){
          echo 'Sale Deleted';
        }?>
	<?php include('footer.php'); ?>
</html>
