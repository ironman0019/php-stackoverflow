

<?php require_once BASE_PATH . '/template/admin/layout/head.php' ?>

<body>

    <?php require_once BASE_PATH . '/template/admin/layout/partials/top-nav.php' ?>

    <div class="container-fluid">
        <div class="row">
            <?php require_once BASE_PATH . '/template/admin/layout/partials/sidebar.php' ?>
        <main role=" main" class=" col-md-9 ml-sm-auto col-lg-10 px-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h5"><i class="fas fa-newspaper"></i> Question</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a role="button" href="<?= url('/admin/question/create') ?>" class="btn btn-sm btn-success">create
                </a>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <caption>List of questions</caption>
            <thead>
                <tr>
                    <th>#</th>
                    <th>title</th>
                    <th>body</th>
                    <th>tags</th>
                    <th>image</th>
                    <th>status</th>
                    <th>user_name</th>
                    <th>setting</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($questions as $question) { ?>
                <tr>
                    <td><?= $question['id'] ?></td>
                    <td><?= $question['title'] ?></td>
                    <td><?= $question['body'] ?></td>
                    <td><?= $question['tags'] ?></td>
                    <td>
                        <?php if($question['image']) { ?>
                            <img src="<?= asset($question['image']) ?>" alt="image" width="100" height="100">
                        <?php } ?>
                    </td>
                    <td><?php if($question['status'] == 0) echo 'open'; elseif($question['status'] == 1) echo 'close'; else echo 'deleted'; ?></td>
                    <td><?= $question['username'] ?></td>
                    <td>
                        <a role="button" href="<?= url('admin/question/edit/' . $question['id']) ?>" class="btn btn-sm btn-info my-0 mx-1 text-white">edit</a>
                        <a role="button" href="<?= url('admin/question/delete/' . $question['id']) ?>" class="btn btn-sm btn-danger my-0 mx-1 text-white">delete</a>
                        <a role="button" href="<?= url('admin/question/'. $question['id'] . '/images') ?>" class="btn btn-sm btn-warning my-1 mx-5 text-dark">images</a>
                    </td>
                    <td><a role="button" href="<?= url('admin/question/'. $question['id'] . '/answers') ?>" class="btn btn-sm btn-primary my-0 mx-1 text-white">answers</a></td>
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