<?php require_once BASE_PATH . '/template/admin/layout/head.php' ?>

<body>

    <?php require_once BASE_PATH . '/template/admin/layout/partials/top-nav.php' ?>

    <div class="container-fluid">
        <div class="row">
            <?php require_once BASE_PATH . '/template/admin/layout/partials/sidebar.php' ?>
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">



                <section class="pt-3 pb-1 mb-2 border-bottom">
                    <h1 class="h5">Create Question Images</h1>
                </section>

                <?php if (flash('create_question_image_error')) { ?>
                    <div class="mb-2 alert alert-danger"> <small class="form-text text-danger"><?= flash('create_question_image_error') ?></small> </div>
                <?php } ?>
                
                <section class="row my-3">
                    <section class="col-12">
                        <form method="post" action="<?= url('/admin/question/' . $question['id'] . '/images/store') ?>" enctype="multipart/form-data">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="customFile" name="image">
                                <label for="customFile" class="custom-file-label">Choose File</label>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">store</button>
                        </form>
                    </section>


            </main>


            <?php require_once BASE_PATH . '/template/admin/layout/scripts.php' ?>

</body>

</html>