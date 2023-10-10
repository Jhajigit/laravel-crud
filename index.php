<?php
include_once 'layouts/header.php';
?>

<?php
session_start();
?>
<?php
$errorString = isset($_GET['errors']) ? $_GET['errors'] : '';

$errors = unserialize(urldecode($errorString));

if (!empty($errors)) {
	foreach ($errors as $error) {
		echo "<p class=' ms-3 text-danger'>$error</p>";
	}
}
?>

<div class="container-fluid  alert alert-danger">
	<div class="row">
		<div class="col-lg-12">
			<div class="card alert-danger border-0">
				<div class="container">
					<div class="row">
						<div class="col-lg-12">
							<div class="card-header bg-transparent border-0 ">
								<div class="row">
									<div class="col-lg-8">
										<h3 class="m-2 text-center mt-3">ADD NEW EMPLOYEE</h3>
									</div>
									<div class="col-lg-4">
										<button type="button" class="btn btn-danger mt-3">
											<a href="listview.php" class="text-decoration-none text-white">VIEW EMPLOYEE LIST</a>
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="card-body border border-danger mt-3 mb-3">
						<form action="store.php" method="POST" name="form" onsubmit="return validate()" enctype="multipart/form-data">
							<div class="form-group">
								<label>Name:</label>
								<input type="text" name="name" class="form-control" placeholder="Enter Name">
								<span class="text-danger" id="err_name"></span>
								<?php
								// if (isset($_SESSION['errorMsg']) && $_SESSION['errorMsg'] == true) {
								// 	echo $_SESSION['errorMsg'];

								// 	foreach ($_SESSION['errorMsg'] as $error) {
								// 		echo "<p>$error</p>";
								// 	}
								// }
								?>
							</div>
							<div class="form-group">
								<label>Email:</label>
								<input type="email" name="email" class="form-control" placeholder="Enter Email">
								<span class="text-danger" id="err_email"></span>
							</div>
							<div class="form-group">
								<label>Phone:</label>
								<input type="text" name="phone" class="form-control" pattern="[0-9]*" placeholder="Enter Mobile Number" onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57" maxlength="10">
								<span class="text-danger" id="err_phone"></span>
							</div>
							<div class="form-group">
								<label>Salary:</label>
								<input type="number" name="salary" class="form-control">
								<span class="text-danger" id="err_salary"></span>
							</div>
							<div class="form-group">
								<label>Status:</label>
								<select class="form-control" name="status">
									<option value selected>--Select Status--</option>
									<option value="1">Active</option>
									<option value="0">In Active</option>
								</select>
								<span class="text-danger" id="err_status"></span>
							</div>
							<div class="form-group">
								<label>Image:</label>
								<input type="file" name="image" class="form-control">
							</div>
							<div class="form-group">
								<label>Address:</label>
								<textarea type="textarea" name="address" class="form-control" rows="3" cols="25"></textarea>
								<span class="text-danger" id="err_address"></span>
							</div>
							<div class="text-center mt-3 mb-3">
								<button type="submit" name="submit" class="btn btn-success">
									Submit
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
include_once 'layouts/footer.php';
?>