<?php
	include('db.php');
    $formSuccess =  $formError = $orderNumber = '';
    $errors = array('orderNumber' => '');

    if(isset($_POST['submit'])){
        $orderNumber = filter_input(INPUT_POST, 'orderNumber', FILTER_SANITIZE_NUMBER_INT);
        
        if(empty($_POST['orderNumber'])){
			$errors['orderNumber'] = 'An item number is required';
		} else{
			$orderNumber = $_POST['orderNumber'];
			if(!is_numeric($orderNumber) || $orderNumber <= 0 || !ctype_digit($orderNumber)){
				$errors['orderNumber'] = 'Item Number must be a positive whole number';
			}
		}

        if(array_filter($errors)){
			$formError = "Errors in form!!";
		} else {
			$orderNumber = $_POST['orderNumber'];
            $sql = 'DELETE FROM sales WHERE OrderNumber = :ordernumber';
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['ordernumber'=> $orderNumber]);
            $formSuccess = 'Order record deleted!';
            //clear inputs and messages
            $orderNumber = $formError = '';
		}
    }

?>

<!DOCTYPE html>
<html>
	
	<?php include('header.php'); ?>
	<h4>Enter an order number to delete</h4>
    <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
				<input type="text" name="orderNumber" value="<?php echo htmlspecialchars($orderNumber) ?>">
                <div class="red-text"><?php echo $errors['orderNumber']; ?></div>
				<input type="submit" name="submit" value="Delete" class="btn brand z-depth-0">
                <a class="btn btn-default" href="index.php" role="button">Cancel</a>
	</form>

   <p class="red-text"><?php 
    if($formSuccess){
			echo $formSuccess;
    }
		?></p>
	<?php include('footer.php'); ?>
</html>
