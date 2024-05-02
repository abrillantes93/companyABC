<?php
	include('config.php');
    include('db.php');
    $formMsg = $orderNumber = '';
    $errors = array('orderNumber' => '');

    if(isset($_POST['submit'])){
        $orderNumber = filter_input(INPUT_POST, 'orderNumber', FILTER_SANITIZE_NUMBER_INT);

        if(empty($_POST['orderNumber'])){
			$errors['orderNumber'] = 'An order number is required';
		} else{
			$orderNumber = $_POST['orderNumber'];
			if(!is_numeric($orderNumber) || $orderNumber <= 0 || !ctype_digit($orderNumber)){
				$errors['orderNumber'] = 'Item Number must be a positive whole number';
			}
		}

        if(array_filter($errors)){
			$formMsg = "Errors in form!!";
		} else {
			$orderNumber = $_POST['orderNumber'];
            $sql = 'DELETE FROM sales WHERE OrderNumber = :ordernumber';
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['ordernumber'=> $orderNumber]);
            $formMsg = 'Order record deleted!';
            //clear inputs and messages
            $orderNumber ='';
		}
    }

?>

<!DOCTYPE html>
<html>
	
	<?php include('header.php'); ?>
	
    <form class="form-horizontal center" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                <label>Enter a order number to delete: </label>
				<input class="form-control" type="text" name="orderNumber" value="<?php echo htmlspecialchars($orderNumber) ?>">
                <div class="red-text"><?php echo $errors['orderNumber']; ?></div>
				<input class="btn btn-default" type="submit" name="submit" value="Delete">
                <a class="btn btn-default" href="index.php" role="button">Cancel</a>
	</form>

   <p class="red-text center"><?php 
        echo $formMsg
		?></p>
	<?php include('footer.php'); ?>
</html>
