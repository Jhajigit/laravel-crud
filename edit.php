<?php
include_once 'layouts/header.php';
?>
<?php
session_start();

?>
<?php

if (isset($_GET['editid']) && is_numeric($_GET['editid'])) {
    $Editid = $_GET['editid'];
    $sql = "SELECT * FROM employee_table WHERE id = $Editid";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
} else if (isset($_POST['update'])) {
    $upid = $_POST['updateid'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $salary = $_POST['salary'];
    $status = $_POST['status'];
    $address = $_POST['address'];


    /*  below commented code for image extension. using for image validation. */
    $newImageName = $_FILES["updateimage"]["name"];

    // $newImageNames = $_FILES["updateimage"]["size"];

    $allowExtension = ["jpg", "jpeg", "png", "gif", "svg"];
    //print_r($allowExtension);
    $extension = explode('.', $newImageName);
    $exe = end($extension);
    if ((!empty($newImageName))) {
        if (in_array($exe, $allowExtension)) {

            /* When correct file name extension will be uploaded. Then bwlow code will  execute */
            $newImageName = $_FILES["updateimage"]["name"];
            $tmpNewFilePath = $_FILES["updateimage"]["tmp_name"]; // Use temporary file path for moving the uploaded file

            $folder = "image/";
            // For images upload 

            $updateImage  = "image/" . $newImageName;

            /* condition for checking the image, exist under the file or not */
            if (file_exists($updateImage)) {

                $extension = explode('.', $newImageName);

                $exeName = $extension[0];
                $exeEnd = $extension[1];
                $newUpdateImage = $exeName .  '_' . mt_rand() . '.' . $exeEnd;
                $tmpFilePath = $_FILES["updateimage"]["tmp_name"];
                $newImagePath = 'image/'; // Path to your image folder

                /* for move the image under the folder */

                if (move_uploaded_file($tmpFilePath, $newImagePath . $newUpdateImage)) {
                    $res = "SELECT * FROM employee_table WHERE id = $upid";
                    $result = $conn->query($res);
                    $row = $result->fetch_assoc();

                    unlink("image/" . $row['image']);
                    $sql = "UPDATE employee_table SET `name`= '$name', `email`='$email', `phone` = '$phone', `salary` ='$salary', `status`= '$status', `image` = '$newUpdateImage', `address`= '$address' WHERE id = $upid ";
                    $result = mysqli_query($conn, $sql);
                    if ($result) {
                        // echo "update image";
                        // exit();
                        $_SESSION['update'] = 'RECORD  UPDATED SUCCESSFULLY!';

                        header("Location: listview.php");
                    } else {
                        $_SESSION['update'] = 'RECORD NOT UPDATED!';

                        header("Location: listview.php");
                    }
                } else {
                    $_SESSION['update'] = 'FILE NOT UPLOADED!';

                    header("Location: listview.php");
                }
            } else {
                /* for delete image from image-folder */
                $res = "SELECT * FROM employee_table WHERE id = $upid";
                $result = $conn->query($res);
                $row = $result->fetch_assoc();
                unlink("image/" . $row['image']);
                //exit;

                $folder = "image/";
                if (move_uploaded_file($tmpNewFilePath, $folder . $newImageName)) {

                    $sql = "UPDATE employee_table SET `name`= '$name', `email`='$email', `phone` = '$phone', `salary` ='$salary', `status`= '$status', `image` = '$newImageName', `address`= '$address' WHERE id = $upid ";
                    $result = mysqli_query($conn, $sql);

                    if ($result) {
                        $_SESSION['update'] = 'RECORD  UPDATED SUCCESSFULLY!';

                        header("Location: listview.php");
                    } else {
                        $_SESSION['update'] = 'RECORD NOT UPDATED!';

                        header("Location: listview.php");
                    }
                } else {
                    echo "Invalid ID.";
                }
            }


            /// echo "extension matched";
        } else {
            // echo "uploaded";
            // exit;
            $_SESSION['imagestore'] = 'Please Select Valid Image File {Only accept these extensions [jpg, jpeg, png, gif, svg]}';
            header("Location: error.php");
            // echo "Please Select Valid Image File {Only accept these extensions [jpg, jpeg, png, gif, svg]}";
        }
    } else {
        /*  when image will not updated by users*/
        $sql = "UPDATE employee_table SET `name`= '$name', `email`='$email', `phone` = '$phone', `salary` ='$salary', `status`= '$status', `address`= '$address' WHERE id = $upid ";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $_SESSION['update'] = 'RECORD  UPDATED SUCCESSFULLY!';
            header("Location: listview.php");
        } else {
            $_SESSION['update'] = 'RECORD NOT UPDATED!';
            header("Location: listview.php");
        }
    }
}

?>
<?php
// if (isset($_SESSION['imagestore'])) {
//     echo "<h2 class= 'alert alert-danger'>" . $_SESSION['imagestore'] . " </h2>";
//     session_destroy();
// }
?>
<?php
if (isset($_GET['editid']) && is_numeric($_GET['editid'])) {
?>
    <div class="container-fluid  alert alert-danger">
        <div class="row">
            <div class="col-lg-12">
                <div class="card alert-danger border-0 ">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card-header alert alert-danger border border-danger mb-0">
                                    <div class="row">
                                        <div class="col-lg-10">
                                            <h3 class="text-center text-decoration-underline ">EDIT EMPLOYEE FORM</h3>
                                        </div>
                                        <div class="col-lg-2">
                                            <button type="button" class="btn btn-danger">
                                                <a class="text-decoration-none text-white" href="listview.php">BACK</a>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body border border-danger mb-3">
                            <form action="edit.php" method="POST" name="form" onsubmit="return validate()" enctype="multipart/form-data">
                                <input type="hidden" name="updateid" value="<?= $row['id'] ?>">
                                <div class="form-group">
                                    <label>Name:</label>
                                    <input type="text" value="<?= $row['name'] ?>" name="name" class="form-control" placeholder="Enter Name">
                                    <span class="text-danger" id="err_name"></span>
                                </div>
                                <div class="form-group">
                                    <label>Email:</label>
                                    <input type="email" value="<?= $row['email'] ?>" name="email" class="form-control" placeholder="Enter Email">
                                    <span class="text-danger" id="err_email"></span>
                                </div>
                                <div class="form-group">
                                    <label>Phone:</label>
                                    <input type="text" value="<?= $row['phone'] ?>" name="phone" class="form-control" pattern="[0-9]*" placeholder="Enter Mobile Number" onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57" maxlength="10">
                                    <span class="text-danger" id="err_phone"></span>
                                </div>
                                <div class="form-group">
                                    <label>Salary:</label>
                                    <input type="number" value="<?= $row['salary'] ?>" name="salary" class="form-control">
                                    <span class="text-danger" id="err_salary"></span>
                                </div>
                                <div class="form-group">
                                    <label>Status:</label>
                                    <select class="form-control" name="status">
                                        <?php
                                        if ($row['status'] == 1) {
                                            echo   "<option value='1' selected > Active</option>";
                                            echo   " <option value='0'  > InActive</option>";
                                        } else {
                                            echo   "<option value='0' selected > InActive</option>";
                                            echo   "<option value='1'  > Active</option>";
                                        }
                                        ?>
                                    </select>
                                    <span class="text-danger" id="err_status"></span>
                                </div>
                                <div class="form-group pt-3">
                                    <label>Image:</label>

                                    <img src="image/<?= $row['image'] ?>" name="image" height="50" width="50" alt="image" title="image" accept="image/*">
                                    <label class="ps-5">Select New:</label>
                                    <input type="file" name="updateimage">

                                </div>
                                <div class="form-group">
                                    <label>Address:</label>
                                    <textarea type="textarea" name="address" class="form-control" rows="3" cols="25"><?= $row['address'] ?></textarea>
                                    <span class="text-danger" id="err_address"></span>
                                </div>
                                <div class="text-center mt-3 mb-3">
                                    <button type="submit" name="update" class="btn btn-primary">UPDATE
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
}
?>
<?php
include_once 'layouts/footer.php';
?>