

<?php require_once BASE_PATH . '/template/admin/layout/head.php' ?>

<body>

    <?php require_once BASE_PATH . '/template/admin/layout/partials/top-nav.php' ?>

    <div class="container-fluid">
        <div class="row">
            <?php require_once BASE_PATH . '/template/admin/layout/partials/sidebar.php' ?>
        <main role=" main" class=" col-md-9 ml-sm-auto col-lg-10 px-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h5"><i class="fas fa-newspaper"></i> Tag</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a role="button" href="<?= url('/admin/tag/create') ?>" class="btn btn-sm btn-success">create
                </a>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <caption>List of tags</caption>
            <thead>
                <tr>
                    <th>#</th>
                    <th>name</th>
                    <th>setting</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($tags as $tag) { ?>
                <tr>
                    <td><?= $tag['id'] ?></td>
                    <td><?= $tag['name'] ?></td>
                    <td>
                        <a role="button" href="<?= url('admin/tag/edit/' . $tag['id']) ?>" class="btn btn-sm btn-info my-0 mx-1 text-white">edit</a>
                        <a role="button" href="<?= url('admin/tag/delete/' . $tag['id']) ?>" class="btn btn-sm btn-danger my-0 mx-1 text-white">delete</a>
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