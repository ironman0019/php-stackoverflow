<?php require_once BASE_PATH . '/template/admin/layout/head.php' ?>

<body>

    <?php require_once BASE_PATH . '/template/admin/layout/partials/top-nav.php' ?>

    <div class="container-fluid">
        <div class="row">
            <?php require_once BASE_PATH . '/template/admin/layout/partials/sidebar.php' ?>
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">



                <section class="pt-3 pb-1 mb-2 border-bottom">
                    <h1 class="h5">Edit question-images</h1>
                </section>

                <?php if (flash('edit_question_image_error')) { ?>
                    <div class="mb-2 alert alert-danger"> <small class="form-text text-danger"><?= flash('edit_question_image_error') ?></small> </div>
                <?php } ?>

                <section class="row my-3">
                    <section class="col-12">
                        <form method="post" action="<?= url('/admin/question/'. $question['id'] .'/images/update/'. $image['id'])?>" enctype="multipart/form-data">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="customFile" name="image">
                                <label for="customFile" class="custom-file-label">Choose File</label>
                            </div>
                            <?php if($image['image']) { ?>
                                <img class="mt-3" src="<?= asset($image['image']) ?>" alt="image" width="100" height="100">
                            <?php } ?>
                            <button type="submit" class="btn btn-primary btn-sm">update</button>
                        </form>
                    </section>


            </main>


            <?php require_once BASE_PATH . '/template/admin/layout/scripts.php' ?>

</body>

</html>