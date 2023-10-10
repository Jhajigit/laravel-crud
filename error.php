<?php
include_once 'layouts/header.php';
?>

<?php
session_start();
?>


<div class="container-fluid alert alert-danger ">
    <div class="card alert alert-danger m-5 border-0">
        <div class="card-header bg-transparent border-0">
            <div class="row">
                <div class="col-lg-12">
                    <div class="d-flex justify-content-center">
                        <button class="btn btn-danger ">
                            <a href="edit.php" class="text-decoration-none text-light">BACK</a>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <h1 class="text-center">ERROR 404</h1>
            <hr />
            <?= "<h5 class='text-center'>" . $_SESSION['imagestore'] . "</h5>"; ?>
        </div>
    </div>
</div>




<?php
include_once 'layouts/footer.php';
?>