<?php require_once BASE_PATH . '/template/admin/layout/head.php' ?>

<body>

    <?php require_once BASE_PATH . '/template/admin/layout/partials/top-nav.php' ?>

    <div class="container-fluid">
        <div class="row">
            <?php require_once BASE_PATH . '/template/admin/layout/partials/sidebar.php' ?>
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">



                <section class="pt-3 pb-1 mb-2 border-bottom">
                    <h1 class="h5">Edit user</h1>
                </section>

                <?php if (flash('edit_user_error')) { ?>
                    <div class="mb-2 alert alert-danger"> <small class="form-text text-danger"><?= flash('edit_user_error') ?></small> </div>
                <?php } ?>

                <section class="row my-3">
                    <section class="col-12">
                        <form method="post" action="<?= url('/admin/users/update/' . $user['id']) ?>">
                            <div class="form-group">
                                <label for="name">Username</label>
                                <input type="text" class="form-control" id="username" name="username"
                                    placeholder="Enter title ..." value="<?= $user['username'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Permission</label>
                                <select class="form-control" id="exampleFormControlSelect1" name="type">
                                    <option value="0" <?php if ($user['type'] == 0) echo 'selected'; ?>>Not admin</option>
                                    <option value="1" <?php if ($user['type'] == 1) echo 'selected'; ?>>Admin</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">update</button>
                        </form>
                    </section>


            </main>


            <?php require_once BASE_PATH . '/template/admin/layout/scripts.php' ?>

</body>

</html>