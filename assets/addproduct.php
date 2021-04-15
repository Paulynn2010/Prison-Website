<?php
/**
 * File
 *
 * Main navigation of the website
 *
 * @Category Components
 * @package  WordPress
 * @author   Lucky Katana <luckykatana73@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @link     https://fashionfix.netlify.app
 * @since    1.0.0
 */

?>

<?php
require_once 'dbConnect.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<?php require 'header.php'; ?>
</head>
<body>
<div class="container-fluid">
<form method="POST" action="" enctype="multipart/form-data">
			<div class="form-elements col-6">
				<div >
					<label for="name">Product Name</label>
					<input type="text" name="prod_name" id="name" required>
				</div>
				<div>
					<label for="image">Product Image</label>
					<input type="file" accept="image/*" name="prod_image" id="image" required>
				</div>
				<div >
					<label for="description">Product Description</label>
					<input type="text" name="prod_desc" id="description" required>
				</div>
				<div >
					<label for="cost">Product Price</label>
					<input type="number" name="prod_price" id="cost" required>
				</div>
				<div>
					<p>Section</p>
					<input type="radio" id="men" name="section" value="Men" required><label for="men">Men</label>
					<input type="radio" id="women" name="section" value="Women" required><label for="women">Women</label>
				</div>
				<div >
				<label for="categorydropdown">Category</label>
				<select name="category[]" id="categorydropdown">
				<option disabled selected>Select Category</option>
				<option value="Shoes">Shoes</option>
				<option value="Skirts">Skirt</option>
				<option value="Jeans">Jeans</option>
				<option value="Tops">Tops</option>
				<option value="Sweater">Sweater</option>
				<option value="Denim">Denim</option>
				<option value="swimsuits">Swimsuits</option>
				<option value="Tshirts">Tshirts</option>
				<option value="Dresses">Dresses</option>
				</select>
				</div>

				<button type="submit" name="addproduct" class="btn btn-outline-info">Save</button>
			</div>
	</form>
<?php

if (isset($_POST['addproduct'])) {
	// Code!
	$unique_id = rand(time(), 100000000);
	$productname = $_POST['prod_name'];
	$image       = $_FILES['prod_image']['name'];
	$description = $_POST['prod_desc'];
	$price       = $_POST['prod_price'];
	$category    = $_POST['category'];
	$fileerror = $_FILES['prod_image']['error'];

	if (is_array($category)){
		$category = implode(',', $category);

	}

	// Code to check whether the radio button has been clicked!
	if (isset($_POST['section'])) {
		// Code to check the value.
		$section = $_POST['section'];
	} else {
		// Code when there is no value.
		$section = null;
	}
	// Code when the button has a value.
	if ($section !== null) {
		// Code when the button has a section men.
		if ($section === 'Men') {

					// Get images!
			$target_dir  = 'images/';
			$target_file = $target_dir . basename($_FILES['prod_image']['name']);

			// Select file type!
			$image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

			// Valid file extensions!
			$extensions_arr = array( 'jpg', 'jpeg', 'png', 'gif', 'jfif' );
			// get the extension of the file
			$fileext = explode('.', $image);
			//change the extension to a lowercase
			$fileactualext =strtolower(end($fileext));
			// change the name of the file to the product id for easy retrieval


			if (in_array($fileactualext, $extensions_arr)) {
				if ($fileerror=== 0) {
					$filenamenew = "".$image.".".$fileactualext;
					$filedestination = 'images/'.$filenamenew;

					// Upload file!
					move_uploaded_file($_FILES['prod_image']['tmp_name'], $filedestination);


					// Insert record!
					$sql = 'INSERT INTO product_details_men ( productName, image, description, price, category,unique_id ) VALUES ( ?, ?, ?, ?, ?,? )';

					// Prepare query!
					if ($stmt = mysqli_prepare($conn, $sql)) {
						// Binding ???
						mysqli_stmt_bind_param($stmt, 'sssisi', $param_name, $param_image, $param_desc, $param_cost, $param_category, $param_uniqueid);

						$param_name     = $productname;
						$param_image    = $image;
						$param_desc     = $description;
						$param_cost     = $price;
						$param_category = $category;
						$param_uniqueid = $unique_id;

						// Executing query!
						if (mysqli_stmt_execute($stmt)) {
							// Code!
							ob_start();

							header('location : viewproduct.php');
							ob_end_flush();

						} else {
							// Code...
							echo mysqli_error($conn);
						}
					} else {
						// Code...
						echo 'there is an issue with your query command' . mysqli_error($conn);
					}
				}
			}
		} else {
			// Code when section is women!
					// Get images!
					$target_dir  = 'images/';
					$target_file = $target_dir . basename($_FILES['prod_image']['name']);

					// Select file type!
					$image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

					// Valid file extensions!
					$extensions_arr = array( 'jpg', 'jpeg', 'png', 'gif', 'jfif' );
					// get the extension of the file
					$fileext = explode('.', $image);
					//change the extension to a lowercase
					$fileactualext =strtolower(end($fileext));
					// change the name of the file to the product id for easy retrieval


					if (in_array($fileactualext, $extensions_arr)) {
						if ($fileerror=== 0) {
							$filenamenew = "".$image.".".$fileactualext;
							$filedestination = 'images/'.$filenamenew;

							// Upload file!
							move_uploaded_file($_FILES['prod_image']['tmp_name'], $filedestination);


							// Insert record!
							$sql = 'INSERT INTO product_details_women ( productName, image, description, price, category,unique_id ) VALUES ( ?, ?, ?, ?, ?,? )';

							// Prepare query!
							if ($stmt = mysqli_prepare($conn, $sql)) {
								// Binding ???
								mysqli_stmt_bind_param($stmt, 'sssisi', $param_name, $param_image, $param_desc, $param_cost, $param_category, $param_uniqueid);

								$param_name     = $productname;
								$param_image    = $image;
								$param_desc     = $description;
								$param_cost     = $price;
								$param_category = $category;
								$param_uniqueid = $unique_id;

								// Executing query!
								if (mysqli_stmt_execute($stmt)) {
									// Code!

									header('location : viewproduct.php');
								} else {
									// Code...
									echo mysqli_error( $conn );
								}
							} else {
								// Code...
								echo 'there is an issue with your query command' . mysqli_error($conn);
							}
						}
					}
		}
	} else {
		// code...
		echo 'section has not been selected';
	}
}
?>
</div>
	</body>
	</html>