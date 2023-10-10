<?php
include_once 'layouts/header.php';
?>
<?php
session_start();
?>


<?php
// firstly select the data from table
// $image = file_get_contents($_FILES["image"]["tmp_name"]);
$sql = "SELECT * FROM employee_table";
$result = $conn->query($sql);
// $$result->bind_param("sss", $name, $email, $phone, $salary, $status, $image,  $address,);

if ($result->num_rows > 0) {
	$data = $result->fetch_all(MYSQLI_ASSOC);
	/*   for view the image link */
	// $filename = $data['filename'];
	// $filename = $_FILES["image"]["name"];
	// $tmpFilePath = $_FILES["image"]["tmp_name"];

	// $imageFilename = $data["image"];

	// Generate the URL to the uploaded image
	// $imageURL = "image/" . $imageFilename;

	// Create a link to display the image
	// echo "<a href='$imageURL' target='_blank'>View Image</a>";

	// $imageFilename = $data["image"];
	// $viewImageURL = "image.php?image=" . urlencode($imageFilename);
	// echo "<a href='$viewImageURL' target='_blank'><img src='$viewImageURL' alt='View Image'></a>";
}
?>
<?php
// for delete the data
if (isset($_GET['delid']) && is_numeric($_GET['delid'])) {
	$idToDelete = $_GET['delid'];
	// $imageToDelete = $_GET['delimage'];
	$sql = "DELETE FROM employee_table WHERE id = $idToDelete"; // Replace with your actual table name

	$res = "SELECT * FROM employee_table WHERE id = $idToDelete";
	$result = $conn->query($res);
	$row = $result->fetch_assoc();

	if ($conn->query($sql) === TRUE) {

		unlink("image/" . $row['image']);
		//	exit();
		$_SESSION['delete'] = 'DELETED SUCCESSFULLY';
		header("Location: listview.php");
	} else {
		echo "Error deleting record: " . $conn->error;
	}
} else {
	echo "";
}

?>
<?php
//for reset search from value
$sName = $sEmail = $sPhone = $sSalary = $sStatus = "";
if (isset($_POST['reset']))
	$sName = $sEmail = $sPhone = $sSalary = $sStatus = "";
?>

<?php
if (isset($_POST['search'])) {
	$sName = $_POST['name'];
	$sStatus = $_POST['status'];

	if (!empty($sName) && ($sStatus != "")) {
		// echo "Please enter name and Select status";
		$s_sql = "SELECT * FROM employee_table WHERE (`name` LIKE '%$sName%' OR `email` LIKE '%$sName%' OR `phone` LIKE '%$sName%') AND `status` ='$sStatus'";
	} else if (!empty($sName)) {
		$s_sql = "SELECT * FROM employee_table WHERE `name` LIKE '%$sName%' OR `email` LIKE '%$sName%' OR `phone` LIKE '%$sName%'";
	} else if (($sStatus != "")) {
		$s_sql = "SELECT * FROM employee_table WHERE `status` ='$sStatus'";
	}

	// $s_sql = "SELECT * FROM employee_table WHERE 1=1";

	// if (!empty($sName)) {
	// 	$s_sql .= " AND (`name` LIKE '%$sName%' OR `email` LIKE '%$sName%' OR `phone` LIKE '%$sName%')";
	// }

	// if ($sStatus == 1 || $sStatus == 0) {
	// 	$s_sql .= " AND `status` = '$sStatus'";
	// }

	$s_result = $conn->query($s_sql);
	$data = $s_result->fetch_all(MYSQLI_ASSOC);
}

?>


<div class="container-fluid alert alert-danger">

	<div>
		<h4 class="text-center">
			<?php

			if (isset($_SESSION['update']) && $_SESSION['update'] == true) {
				echo $_SESSION['update'];
				session_destroy();
			} else if (isset($_SESSION['insert']) && $_SESSION['insert'] == true) {
				echo $_SESSION['insert'];
			} else if (isset($_SESSION['delete']) && $_SESSION['delete'] == true) {
				echo $_SESSION['delete'];
			}
			?>

		</h4>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="card border border-danger m-5">
				<div class="card-header alert alert-danger ">
					<div class="row">
						<div class="col-lg-12">
							<div class="row">
								<div class="col-lg-6">
									<h3 class="m-2 ms-3">EMPLOYEE LIST</h3>
								</div>
								<div class="col-lg-6">
									<h3 class="text-center m-2">
										<button class="btn btn-primary">
											<a href="index.php" class="text-decoration-none text-white">ADD NEW EMPLOYEE</a>
										</button>
									</h3>
								</div>
							</div>
						</div>
					</div>
					<!-- for search button -->
					<div class="row">
						<div class="col-lg-12">
							<div class="card border border-danger m-2">
								<div class="card-header alert alert-danger mb-0">
									<form action="listview.php" method="POST">
										<div class="row">
											<div class="col-md-4">
												<div class="text-center">
													<input type="text" class="form-control" value="<?php echo $sName ?>" placeholder="search by name, email, phone" name="name">
												</div>
											</div>
											<div class="col-md-4">
												<div class="">

													<select name="status" class="form-control">
														<option value="" selected>--SelectStatus--</option>
														<option value=" 1" <?= $sStatus === '1' ? 'selected' : '' ?>>Active</option>
														<option value="0" <?= $sStatus === '0' ? 'selected' : '' ?>>InActive</option>
													</select>
												</div>
											</div>
											<div class="col-md-4">
												<button class="btn btn-success btn-md" name="search" type="submit">SEARCH</button>
												<button class="btn btn-danger btn-md ms-2" name="reset" type="submit">RESET</button>
											</div>


										</div>

									</form>

								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card-body  mt-0">
					<div class="table-responsive">
						<table class="table">
							<thead>
								<tr>
									<th class="text-center">Sr.No.</th>
									<th class="text-center">NAME</th>
									<th class="text-center">EMAIL</th>
									<th class="text-center">PHONE</th>
									<th class="text-center">SALARY</th>
									<th class="text-center">STATUS</th>
									<th class="text-center">IMAGE</th>
									<th class="text-center">ACTION</th>

								</tr>
							</thead>
							<tbody>
								<?php
								$serialNumber = 1;
								if (!empty($data)) {
									foreach ($data as $row) {
								?>
										<tr class=" text-center ">
											<th scope="row"><?= $serialNumber; ?>
											</th>

											<td><?php echo $row['name']; ?></td>
											<td><?= $row['email']; ?></td>
											<td><?= $row['phone']; ?></td>
											<td><?= $row['salary']; ?></td>
											<td><?= $row['status'] == 1 ? '<span class="text-success">Active</span>' : '<span class="text-danger">InActive</span>'; ?></td>
											<td><img src="image/<?= $row['image']; ?>" height="70" width="70"></td>

											<td>
												<button type="button" class="btn btn-primary ms-3">
													<a href="edit.php?editid=<?= $row['id']; ?>" class="text-decoration-none text-white">
														Edit
													</a>
												</button>
												<button type="button" class="btn btn-success ms-3">
													<a href="view.php?viewid=<?= $row['id']; ?>" class="text-decoration-none text-white">
														View
													</a>
												</button>
												<button type="button" class="btn btn-danger ms-3">
													<a href="listview.php?delid=<?= $row['id']; ?>" class="text-decoration-none text-white">
														Delete
													</a>
												</button>
											</td>

										<?php
										$serialNumber++;
									}

										?>
										</tr>
									<?php
								} else {
									echo '<p class="text-center">No Record Found</p>';
								}
									?>
							</tbody>
						</table>
					</div>
				</div>
				<?php
				$itemsPerPage = 5;

				?>
			</div>
		</div>
	</div>
</div>

<?php
include_once 'layouts/footer.php';
?>