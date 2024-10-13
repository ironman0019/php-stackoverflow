<?php require_once BASE_PATH . '/template/admin/layout/head.php' ?>

<body>

    <?php require_once BASE_PATH . '/template/admin/layout/partials/top-nav.php' ?>

    <div class="container-fluid">
        <div class="row">
            <?php require_once BASE_PATH . '/template/admin/layout/partials/sidebar.php' ?>
            <main role=" main" class=" col-md-9 ml-sm-auto col-lg-10 px-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h5"><i class="fas fa-comments"></i> Show comment</h1>
                </div>
                <section class="row my-3 ">
                    <section class="col-12 ">
                        <h1 class="h4 border-bottom ">body</h1>
                        <p class="text-secondary border-bottom "><?= $comment['body'] ?></p>

                        <h1 class="h4 border-bottom ">question_body</h1>
                        <p class="text-secondary border-bottom ">
                            <?php echo $comment['question_body'] ? $comment['question_body'] : 'Null'; ?>
                        </p>

                        <h1 class="h4 border-bottom ">answer_body</h1>
                        <p class="text-secondary border-bottom ">
                            <?php echo $comment['answer_body'] ? $comment['answer_body'] : 'Null'; ?>
                        </p>

                        <h1 class="h4 border-bottom ">status</h1>
                        <p class="text-secondary border-bottom ">
                            <?php if($comment['status'] == 0) echo "Not approved"; else echo "Approved"; ?>
                        </p>

                        <h1 class="h4 border-bottom ">created_at</h1>
                        <p class="text-secondary border-bottom "><?= jalali($comment['created_at']) ?></p>

                        <?php if($comment['status'] == 0) { ?>
                            <a role="button" href="<?= url('admin/comments/status/' . $comment['id']) ?>" class="btn btn-sm btn-success my-0 mx-1 text-white">click to approved</a>
                        <?php } else { ?>
                            <a role="button" href="<?= url('admin/comments/status/' . $comment['id']) ?>" class="btn btn-sm btn-danger my-0 mx-1 text-white">click not to approved</a>
                        <?php } ?>

                    </section>
                </section>
            </main>
        </div>
    </div>





    <?php require_once BASE_PATH . '/template/admin/layout/scripts.php' ?>

</body>

</html>