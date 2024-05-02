<?php
	include('db.php');

	// Variable declarations
	$itemNumber = $description = $size = $color = $price = $formError = $formSuccess = '';
	$errors = array('itemNumber' => '', 'description' => '', 'size' => '', 'color' => '', 'price' => '');
	
	// Color and size options
	$standard_colors = array('black','blue','green','purple','red','white','yellow');
	$standard_sizes = array('s','m','l','xl','xxl');

	if(isset($_POST['submit'])){ 
		// input sanitization
		$itemNumber = filter_input(INPUT_POST, 'itemNumber', FILTER_SANITIZE_NUMBER_INT);
		$description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
		$size = filter_input(INPUT_POST, 'size', FILTER_SANITIZE_STRING);
		$color = filter_input(INPUT_POST, 'color', FILTER_SANITIZE_STRING);
		$price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
		//input validation
		if(empty($itemNumber)){
			$errors['itemNumber'] = 'An item number is required';
		} elseif(!ctype_digit($itemNumber)){
			$errors['itemNumber'] = 'Item Number must be a positive whole number';
		}

		if(empty($description)){
			$errors['description'] = 'A description is required';
		} elseif(!preg_match('/^[a-zA-Z\s]+$/', $description)){
			$errors['description'] = 'Description must contain letters only';
		}

		if(empty($size)){
			$errors['size'] = 'A size is required';
		} elseif(!in_array(strtolower($size), $standard_sizes)){
			$errors['size'] = 'Not a valid size';
		}

		if(empty($color)){
			$errors['color'] = 'A color is required';
		} elseif(!in_array(strtolower($color), $standard_colors)){
			$errors['color'] = 'Not a valid color';
		}

		if(empty($price)){
			$errors['price'] = 'A price is required';
		} elseif($price <= 0){
			$errors['price'] = 'Price must be a positive number';
		}

		if(array_filter($errors)){
			$formError = "Errors in form!!";
		} else {
			$sql = 'INSERT INTO sales(ItemNumber, Description, Size, Color, Price) VALUES(:itemNumber, :description, :size, :color, :price)';
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['itemNumber' => $itemNumber, 'description' => $description, 'size' => $size, 'color' => $color, 'price' => $price]);
			$formSuccess = "Order Added!";
			$itemNumber = $description = $size = $color = $price = $formError = '';

		}
	}
?>

<!DOCTYPE html>
<html>
	
	<?php include('header.php'); ?>
	
	<section>
		<h4 class="center">Add a sale</h4>
		<!-- error/success message -->
		<p class="red-text center"><?php echo $formError ? $formError : $formSuccess; ?></p>

		<form class="form-horizontal center" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
			<label>Item Number</label>
			<input type="text" name="itemNumber" value="<?php echo htmlspecialchars($itemNumber) ?>">
			<div class="red-text"><?php echo $errors['itemNumber']; ?></div>
			<label>Description</label>
			<input type="text" name="description" value="<?php echo htmlspecialchars($description) ?>">
			<div class="red-text"><?php echo $errors['description']; ?></div>
			<label>Size</label>
			<input type="text" name="size" value="<?php echo htmlspecialchars($size) ?>">
			<div class="red-text"><?php echo $errors['size']; ?></div>
			<label>Color</label>
			<input type="text" name="color" value="<?php echo htmlspecialchars($color) ?>">
			<div class="red-text"><?php echo $errors['color']; ?></div>
			<label>Price</label>
			<input type="text" name="price" value="<?php echo htmlspecialchars($price) ?>">
			<div class="red-text"><?php echo $errors['price']; ?></div>
			<div>
				<input class="btn btn-default" type="submit" name="submit" value="Submit">
				<a class="btn btn-default" href="index.php" role="button">Cancel</a>
			</div>
		</form>
	</section>

	<?php include('footer.php'); ?>

</html>
