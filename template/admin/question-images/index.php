

<?php require_once BASE_PATH . '/template/admin/layout/head.php' ?>

<body>

    <?php require_once BASE_PATH . '/template/admin/layout/partials/top-nav.php' ?>

    <div class="container-fluid">
        <div class="row">
            <?php require_once BASE_PATH . '/template/admin/layout/partials/sidebar.php' ?>
        <main role=" main" class=" col-md-9 ml-sm-auto col-lg-10 px-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h5"><i class="fas fa-image"></i> Images Gallery</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a role="button" href="<?= url('/admin/question/' . $question['id'] . '/images/create') ?>" class="btn btn-sm btn-success">create
                </a>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <caption>List of images</caption>
            <thead>
                <tr>
                    <th>#</th>
                    <th>image</th>
                    <th>setting</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($images as $image) { ?>
                <tr>
                    <td><?= $image['id'] ?></td>
                    <td><img src="<?=asset($image['image'])?>" alt="image" width="100" height="100"></td>
                    <td>
                        <a role="button" href="<?= url('admin/question/' . $question['id'] . '/images/edit/' . $image['id']) ?>" class="btn btn-sm btn-info my-0 mx-1 text-white">edit</a>
                        <a role="button" href="<?= url('admin/question/' . $question['id'] . '/images/delete/' . $image['id'])  ?>" class="btn btn-sm btn-danger my-0 mx-1 text-white">delete</a>
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