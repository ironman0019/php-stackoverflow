<?php require_once BASE_PATH . '/template/admin/layout/head.php' ?>

<body>

    <?php require_once BASE_PATH . '/template/admin/layout/partials/top-nav.php' ?>

    <div class="container-fluid">
        <div class="row">
            <?php require_once BASE_PATH . '/template/admin/layout/partials/sidebar.php' ?>
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">



                <section class="pt-3 pb-1 mb-2 border-bottom">
                    <h1 class="h5">Update Answer</h1>
                </section>

                <?php if (flash('edit_answer_error')) { ?>
                    <div class="mb-2 alert alert-danger"> <small class="form-text text-danger"><?= flash('edit_answer_error') ?></small> </div>
                <?php } ?>

                <section class="row my-3">
                    <section class="col-12">
                        <form method="post" action="<?= url('/admin/question/' . $question['id'] . '/answers/update/' . $answer['id']) ?>">
                            <div class="form-group">
                                <label for="name">Title</label>
                                <input type="text" class="form-control" id="body" name="body"
                                    placeholder="Enter body ..." value="<?= $answer['body'] ?>">
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Status</label>
                                <select class="form-control" id="exampleFormControlSelect1" name="is_accepted">
                                    <option <?php if($answer['is_accepted'] == 0) echo 'selected'; ?> value="0">no</option>
                                    <option <?php if($answer['is_accepted'] == 1) echo 'selected'; ?> value="1">yes</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">User</label>
                                <select class="form-control" id="exampleFormControlSelect1" name="user_id">
                                    <?php foreach ($users as $user) { ?>
                                        <option <?php if($answer['user_id'] == $user['id']) echo 'selected'; ?> value="<?= $user['id'] ?>"><?= $user['username'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">update</button>
                        </form>
                    </section>


            </main>


            <?php require_once BASE_PATH . '/template/admin/layout/scripts.php' ?>

</body>

</html>