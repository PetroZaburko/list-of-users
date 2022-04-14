<?php
session_start();
include_once 'functions.php';
isUserLogged();
hasReuest($_GET['id']);

if($_SESSION['authUser']['is_admin'] || $_GET['id'] == $_SESSION['authUser']['id']) {
    $user = getUserById($_GET['id']);
}
else {
    setFlashMessage('danger', 'You can edit only your own profile !');
    redirectTo('users.php');
}
?>


<!DOCTYPE html>
<html lang="en">
<?php require_once 'head.php'?>
<body>
    <?php require_once 'nav.php'?>
    <main id="js-page-content" role="main" class="page-content mt-3">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-plus-circle'></i> Edit
            </h1>

        </div>
        <form action="edit_user.php" method="post">
            <div class="row">
                <div class="col-xl-6">
                    <div id="panel-1" class="panel">
                        <div class="panel-container">
                            <div class="panel-hdr">
                                <h2>General information</h2>
                            </div>
                            <div class="panel-content">
                                <!-- id -->
                                <input type="hidden" id="id" class="form-control" name="id" value="<?= $user['id'];?>">
                                <!-- username -->
                                <div class="form-group">
                                    <label class="form-label" for="name">Name</label>
                                    <input type="text" id="name" name="name" class="form-control" value="<?= $user['name'] ?>">
                                </div>

                                <!-- title -->
                                <div class="form-group">
                                    <label class="form-label" for="company">Work place</label>
                                    <input type="text" id="company" name="company" class="form-control" value="<?= $user['company'] ?>">
                                </div>

                                <!-- tel -->
                                <div class="form-group">
                                    <label class="form-label" for="telephone">Phone</label>
                                    <input type="text" id="telephone" name="telephone" class="form-control" value="<?= $user['telephone'] ?>">
                                </div>

                                <!-- address -->
                                <div class="form-group">
                                    <label class="form-label" for="address">Address</label>
                                    <input type="text" id="address" name="address" class="form-control" value="<?= $user['address'] ?>">
                                </div>
                                <div class="col-md-12 mt-3 d-flex flex-row-reverse">
                                    <button class="btn btn-warning">Edit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </main>

    <script src="js/vendors.bundle.js"></script>
    <script src="js/app.bundle.js"></script>
    <script>

        $(document).ready(function()
        {

            $('input[type=radio][name=contactview]').change(function()
                {
                    if (this.value == 'grid')
                    {
                        $('#js-contacts .card').removeClassPrefix('mb-').addClass('mb-g');
                        $('#js-contacts .col-xl-12').removeClassPrefix('col-xl-').addClass('col-xl-4');
                        $('#js-contacts .js-expand-btn').addClass('d-none');
                        $('#js-contacts .card-body + .card-body').addClass('show');

                    }
                    else if (this.value == 'table')
                    {
                        $('#js-contacts .card').removeClassPrefix('mb-').addClass('mb-1');
                        $('#js-contacts .col-xl-4').removeClassPrefix('col-xl-').addClass('col-xl-12');
                        $('#js-contacts .js-expand-btn').removeClass('d-none');
                        $('#js-contacts .card-body + .card-body').removeClass('show');
                    }

                });

                //initialize filter
                initApp.listFilter($('#js-contacts'), $('#js-filter-contacts'));
        });

    </script>
</body>
</html>