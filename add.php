<?php
	include('db.php');

	//variable declarations

	$itemNumber = $description = $size = $color = $price = $formError = '';
	$errors = array('itemNumber' => '', 'description' => '', 'size' => '', 'color' => '', 'price' => '');
	
	//color size options
	$standard_colors = array('black','blue','green','purple','red','white','yellow');
	$standard_sizes = array('s','m','l','xl','xxl');


	if(isset($_POST['submit'])){ //input validation
		
		if(empty($_POST['itemNumber'])){
			$errors['itemNumber'] = 'An item number is required';
		} else{
			$itemNumber = $_POST['itemNumber'];
			if(!is_numeric($itemNumber)){
				$errors['itemNumber'] = 'Item Number must be a number';
			}
		}

		if(empty($_POST['description'])){
			$errors['description'] = 'A description is required';
		} else{
			$description = $_POST['description'];
			if(!preg_match('/^[a-zA-Z\s]+$/', $description)){
				$errors['description'] = 'Description must be letters only';
			}
		}

		if(empty($_POST['size'])){
			$errors['size'] = 'A size is required';
		} else{
			$size = $_POST['size'];
			if(!preg_match('/^[a-zA-Z\s]+$/', $size)){
				$errors['size'] = 'Size must be letters only';
			}
		}

		if(empty($_POST['color'])){
			$errors['color'] = 'A color is required';
		} else{
			$color = $_POST['color'];
			if(!preg_match('/^[a-zA-Z\s]+$/', $color)){
				$errors['color'] = 'Color must be letters only';
			}
		}

		if(empty($_POST['price'])){
			$errors['price'] = 'A price is required';
		} else{
			$price = $_POST['price'];
			if(!is_numeric($price)){
				$errors['price'] = 'Price must be a number';
			}
		}

		if(array_filter($errors)){
			$formError = "Errors in form!!";
		} else {
			$sql = 'INSERT INTO sales(ItemNumber, Description, Size, Color, Price) VALUES(:itemNumber, :description, :size, :color, :price)';
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['itemNumber' => $itemNumber, 'description' => $description, 'size' => $size, 'color' => $color, 'price' => $price]);
			echo 'Success';
		}

	}
?>

<!DOCTYPE html>
<html>
	
	<?php include('header.php'); ?>
	<style>
		.red-text { color: red; }
	</style>
	<section>
		<h4>Add a sale</h4>
		<p class="red-text"><?php if(array_filter($errors)){
			echo $formError;
		} ?></p>


		<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
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
