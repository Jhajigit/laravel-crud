<?php include_once('layouts/connection.php') ?>

<?php

session_start();

?>
<?php

if (isset($_POST['submit'])) {
	$name = $_POST['name'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$salary = $_POST['salary'];
	$status = $_POST['status'];
	$address = $_POST['address'];

	$errors = [];

	if (empty($name)) {
		$errors[] = "Enter the valid name.";
	}
	if (empty($email)) {
		$errors[] = "Enter your Email Address.";
	}
	if (empty($phone)) {
		$errors[] = "Enter the phone number";
	}
	if (empty($salary)) {
		$errors[] = "Enter the salary";
	}
	if ($status == "") {
		$errors[] = "Please select the status";
	}
	if (empty($address)) {
		$errors[] = "Please enter the address.";
	}

	$errorString = urlencode(serialize($errors));

	if (!empty($errors)) {
		header("Location: index.php?errors=$errorString");
		exit;
	}


	// For images upload 
	$filename = $_FILES["image"]["name"];
	$tmpFilePath = $_FILES["image"]["tmp_name"];
	$imagePath = 'image/' . $filename; // Path to your image folder


	/* for check the image extension */


	if ($filename == "") {
		/*  When file is empty  */

		$sql = "INSERT INTO `employee_table` (`name`, `email`, `phone`, `salary`, `status`, `address`) VALUES ('$name', '$email', '$phone', '$salary', '$status', '$address')";
		if ($conn->query($sql) === true) {
			$_SESSION['insert'] = 'ADDED SUCCESSFULLY';
			header("Location: listview.php");
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
	} else {

		$allowExtension = ["jpg", "jpeg", "png", "gif", "svg"];
		$extension = explode('.', $filename);
		// print_r($extension);
		// exit;
		$exe = end($extension);
		if (in_array($exe, $allowExtension)) {


			/* when image */

			if (file_exists($imagePath)) {
				$extension = explode('.', $filename);

				$exeName = $extension[0];
				$exeEnd = $extension[1];
				$newImagename = $exeName .  '_' . mt_rand() . '.' . $exeEnd;
				// print_r($newImagename);
				// exit;

				$newImagePath = 'image/'; // Path to your image folder

				if (move_uploaded_file($tmpFilePath, $newImagePath . $newImagename)) {
					$sql = "INSERT INTO `employee_table` (`name`, `email`, `phone`, `salary`, `status`, `image`, `address`) VALUES ('$name', '$email', '$phone', '$salary', '$status', '$newImagename', '$address')";
					if (
						$conn->query($sql) === true
					) {
						$_SESSION['insert'] = 'ADDED SUCCESSFULLY';
						header("Location: listview.php");
					} else {
						echo "Error: " . $sql . "<br>" . $conn->error;
					}
				} else {
					echo "Error uploading image.";
				}
			} else {
				/*  when image does not match upload new image   */
				$imagePath = 'image/';
				if (move_uploaded_file($tmpFilePath, $imagePath . $filename)) {
					$imageName = $_FILES["image"]["name"];
					// print_r($imageName);
					// exit;
					$sql = "INSERT INTO `employee_table` (`name`, `email`, `phone`, `salary`, `status`, `image`, `address`) VALUES ('$name', '$email', '$phone', '$salary', '$status', '$imageName', '$address')";
					if ($conn->query($sql) === true) {
						$_SESSION['insert'] = 'ADDED SUCCESSFULLY';
						header("Location: index.php");
					} else {
						echo "Error: " . $sql . "<br>" . $conn->error;
					}
				} else {
					echo "Error uploading image.";
				}
			}
		} else {
			echo "not updated";
		}
	}
}
?>

<?php

$errors = [];

if (empty($name)) {
	$errors[] = "Username is required.";
	// $_SESSION['errorMsg'] = $errors;
	// header("Location: index.php");
}

if (!empty($errors)) {
	foreach ($errors as $error) {
		echo "<p>$error</p>";
	}
}


?>