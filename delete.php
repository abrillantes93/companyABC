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
	
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
				<input type="text" name="orderToDelete" value="<?php echo htmlspecialchars($orderNumber) ?>">
				<input type="submit" name="submit" value="Delete" class="btn brand z-depth-0">
	</form>

    <?php if(isset($_POST['submit'])){
          echo 'Sale Deleted';
        }?>
	<?php include('footer.php'); ?>
</html>
