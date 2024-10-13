

<?php require_once BASE_PATH . '/template/admin/layout/head.php' ?>

<body>

    <?php require_once BASE_PATH . '/template/admin/layout/partials/top-nav.php' ?>

    <div class="container-fluid">
        <div class="row">
            <?php require_once BASE_PATH . '/template/admin/layout/partials/sidebar.php' ?>
        <main role=" main" class=" col-md-9 ml-sm-auto col-lg-10 px-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h5"><i class="fas fa-users"></i> Users</h1>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <caption>List of users</caption>
            <thead>
                <tr>
                    <th>#</th>
                    <th>username</th>
                    <th>email</th>
                    <th>permission</th>
                    <th>created_at</th>
                    <th>setting</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($users as $user) { ?>
                <tr>
                    <td><?= $user['id'] ?></td>
                    <td><?= $user['username'] ?></td>
                    <td><?= $user['email'] ?></td>
                    <td><?php if($user['type'] == 0) echo "Not admin"; else echo "Admin"; ?></td>
                    <td><?= jalali($user['created_at']) ?></td>
                    <td>
                        <?php if($user['type'] == 0) { ?>
                            <a role="button" href="<?= url('admin/users/type/' . $user['id']) ?>" class="btn btn-sm btn-success my-0 mx-1 text-white">click to be admin</a>
                        <?php } else { ?>
                            <a role="button" href="<?= url('admin/users/type/' . $user['id']) ?>" class="btn btn-sm btn-warning my-0 mx-1 text-white">click not to be admin</a>
                        <?php } ?>
                    </td>
                    <td>
                        <a role="button" href="<?= url('admin/users/edit/' . $user['id']) ?>" class="btn btn-sm btn-primary my-0 mx-1 text-white">edit</a>
                        <a role="button" href="<?= url('admin/users/delete/' . $user['id']) ?>" class="btn btn-sm btn-danger my-0 mx-1 text-white">delete</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    </div>
    </div>


    </main>


    <?php require_once BASE_PATH . '/template/admin/layout/scripts.php' ?>

</body>

</html>