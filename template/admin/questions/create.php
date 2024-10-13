<?php require_once BASE_PATH . '/template/admin/layout/head.php' ?>

<body>

    <?php require_once BASE_PATH . '/template/admin/layout/partials/top-nav.php' ?>

    <div class="container-fluid">
        <div class="row">
            <?php require_once BASE_PATH . '/template/admin/layout/partials/sidebar.php' ?>
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">



                <section class="pt-3 pb-1 mb-2 border-bottom">
                    <h1 class="h5">Create Question</h1>
                </section>
                <?php if (flash('create_question_error')) { ?>
                    <div class="mb-2 alert alert-danger"> <small class="form-text text-danger"><?= flash('create_question_error') ?></small> </div>
                <?php } ?>
                <section class="row my-3">
                    <section class="col-12">
                        <form method="post" action="<?= url('/admin/question/store') ?>" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="name">Title</label>
                                <input type="text" class="form-control" id="title" name="title"
                                    placeholder="Enter title ...">
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label">Body</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="body"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Status</label>
                                <select class="form-control" id="exampleFormControlSelect1" name="status">
                                    <option value="0">Open</option>
                                    <option value="1">Close</option>
                                    <option value="2">Deleted</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">User</label>
                                <select class="form-control" id="exampleFormControlSelect1" name="user_id">
                                    <?php foreach ($users as $user) { ?>
                                        <option value="<?= $user['id'] ?>"><?= $user['username'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Tags</label>
                                <select class="js-example-basic-multiple form-control" multiple="multiple" id="exampleFormControlSelect1" name="tags[]">
                                    <?php foreach ($tags as $tag) { ?>
                                        <option value="<?= $tag['id'] ?>"><?= $tag['name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
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