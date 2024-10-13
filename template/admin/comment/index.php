

<?php require_once BASE_PATH . '/template/admin/layout/head.php' ?>

<body>

    <?php require_once BASE_PATH . '/template/admin/layout/partials/top-nav.php' ?>

    <div class="container-fluid">
        <div class="row">
            <?php require_once BASE_PATH . '/template/admin/layout/partials/sidebar.php' ?>
        <main role=" main" class=" col-md-9 ml-sm-auto col-lg-10 px-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h5"><i class="fas fa-comments"></i> Comments</h1>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <caption>List of comments</caption>
            <thead>
                <tr>
                    <th>#</th>
                    <th>username</th>
                    <th>question_title</th>
                    <th>answer_title</th>
                    <th>comment</th>
                    <th>status</th>
                    <th>setting</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($comments as $comment) { ?>
                <tr>
                    <td><?= $comment['id'] ?></td>
                    <td><?= $comment['username'] ?></td>
                    <td><?php echo $comment['question_title'] ? $comment['question_title'] : 'Null'; ?></td>
                    <td>
                        <?php if($comment['answer_title'] != null) echo mb_strimwidth($comment['answer_title'], 0, 10, "..."); else echo 'Null'; ?>
                    </td>
                    <td><?= $comment['body'] ?></td>
                    <td><?php if($comment['status'] == 0) echo "Not approved"; else echo "Approved"; ?></td>
                    <td>
                        <?php if($comment['status'] == 0) { ?>
                            <a role="button" href="<?= url('admin/comments/status/' . $comment['id']) ?>" class="btn btn-sm btn-success my-0 mx-1 text-white">click to approved</a>
                        <?php } else { ?>
                            <a role="button" href="<?= url('admin/comments/status/' . $comment['id']) ?>" class="btn btn-sm btn-danger my-0 mx-1 text-white">click not to approved</a>
                        <?php } ?>
                    </td>
                    <td><a role="button" href="<?= url('admin/comments/show/' . $comment['id']) ?>" class="btn btn-sm btn-primary my-0 mx-1 text-white">show</a></td>
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