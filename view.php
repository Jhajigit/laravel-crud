<?php
include_once 'layouts/header.php';
?>

<?php
// firstly select the data from table
if (isset($_GET['viewid']) && is_numeric($_GET['viewid'])) {
    $Viewid = $_GET['viewid'];
    $sql = "SELECT * FROM employee_table WHERE id = $Viewid";
    $result = $conn->query($sql);
    // $data = $result->fetch_all(MYSQLI_ASSOC);


    if ($result->num_rows > 0) {
        $data = $result->fetch_all(MYSQLI_ASSOC);
    }
} else {
    echo "No records found.";
}
?>

<div class="container-fluid alert alert-danger">
    <div class="card alert alert-danger border border-danger m-5">
        <div class="card-header alert alert-danger border-0 mt-0 mb-0">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-10">
                            <div>
                                <h3 class="text-center text-uppercase">view employee detail</h3>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div>
                                <button class="btn btn-danger">
                                    <a href="listview.php" class="text-decoration-none text-light">BACK</a>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body ">
            <div class="container">
                <div class="table-responsive-md">
                    <table class="table table-hover table-striped table-light table-bordered">

                        <tbody class="">
                            <?php
                            foreach ($data as $row) {
                            ?>
                                <tr class="text-center">
                                    <td>NAME</td>
                                    <td><?= $row['name']; ?></td>

                                </tr>
                                <tr class="text-center">
                                    <td>EMAIL</td>
                                    <td><?= $row['email']; ?></td>
                                </tr>
                                <tr class="text-center">
                                    <td>PHONE</td>
                                    <td><?= $row['phone']; ?></td>
                                </tr>
                                <tr class="text-center">
                                    <td>SALARY</td>
                                    <td><?= $row['salary']; ?></td>
                                </tr>
                                <tr class="text-center">
                                    <td>STATUS</td>
                                    <td><?= $row['status'] == 1 ? 'Active' : 'InActive'; ?></td>
                                </tr>

                                <tr class="text-center">
                                    <td>ADDRESS</td>
                                    <td><?= $row['address']; ?></td>
                                </tr>

                            <?php

                            }
                            ?>
                        </tbody>

                    </table>
                    <!-- <div class="text-center">
                        <button type="button" class="btn btn-primary btn-lg">EDIT</button>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</div>