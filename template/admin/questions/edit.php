<?php require_once BASE_PATH . '/template/admin/layout/head.php' ?>

<body>

    <?php require_once BASE_PATH . '/template/admin/layout/partials/top-nav.php' ?>

    <div class="container-fluid">
        <div class="row">
            <?php require_once BASE_PATH . '/template/admin/layout/partials/sidebar.php' ?>
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">



                <section class="pt-3 pb-1 mb-2 border-bottom">
                    <h1 class="h5">Edit question</h1>
                </section>

                <?php if (flash('edit_question_error')) { ?>
                    <div class="mb-2 alert alert-danger"> <small class="form-text text-danger"><?= flash('edit_question_error') ?></small> </div>
                <?php } ?>

                <section class="row my-3">
                    <section class="col-12">
                        <form method="post" action="<?= url('/admin/question/update/' . $question['id']) ?>" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="name">Title</label>
                                <input type="text" class="form-control" id="title" name="title"
                                    placeholder="Enter title ..." value="<?= $question['title'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label">Body</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="body"><?= $question['body'] ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Status</label>
                                <select class="form-control" id="exampleFormControlSelect1" name="status">
                                    <option value="0" <?php if($question['status'] == 0) echo 'selected'; ?>>Open</option>
                                    <option value="1" <?php if($question['status'] == 1) echo 'selected'; ?>>Close</option>
                                    <option value="2" <?php if($question['status'] == 2) echo 'selected'; ?>>Deleted</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">User</label>
                                <select class="form-control" id="exampleFormControlSelect1" name="user_id">
                                    <?php foreach($users as $user) { ?>
                                    <option <?php if($question['user_id'] == $user['id']) echo 'selected'; ?> value="<?= $user['id'] ?>"><?= $user['username'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Tags</label>
                                <select class="js-example-basic-multiple form-control" multiple="multiple" id="exampleFormControlSelect1" name="tags[]">
                                    <?php $question_tag_ids = array_column($question_tags, 'tag_id'); ?>

                                    <?php foreach($tags as $tag) { ?>
                                        <option <?php if(in_array($tag['id'], $question_tag_ids)) echo 'selected'; ?> 
                                        value="<?= $tag['id'] ?>"><?= $tag['name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="customFile" name="image">
                                <label for="customFile" class="custom-file-label">Choose File</label>
                            </div>
                            <?php if($question['image']) { ?>
                                <img class="mt-3" src="<?= asset($question['image']) ?>" alt="image" width="100" height="100">
                            <?php } ?>
                            <button type="submit" class="btn btn-primary btn-sm">update</button>
                        </form>
                    </section>


            </main>


            <?php require_once BASE_PATH . '/template/admin/layout/scripts.php' ?>

</body>

</html>