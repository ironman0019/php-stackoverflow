<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <title>ویرایش سوال</title>

    <?php require_once BASE_PATH . '/template/app/layout/head-tag.php' ?>

</head>

<body>

    <?php require_once BASE_PATH . '/template/app/layout/partials/header.php' ?>


    <div class="container mt-4">
        <div class="row">
            <div class="col-lg-9 col-md-12">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3>ویرایش سوال</h3>
                </div>


                <?php if (flash('alert')) { ?>
                    <div class="mb-2 alert alert-danger"> <small class="form-text text-danger"><?= flash('alert') ?></small> </div>
                <?php } ?>
                <?php if (flash('success')) { ?>
                    <div class="mb-2 alert alert-success"> <small class="form-text text-success"><?= flash('success') ?></small> </div>
                <?php } ?>

                <div class="container">
                    <form method="post" action="<?= url('question/update/' . $question['id']) ?>" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="form-group my-2">
                                <label for="title">عنوان</label>
                                <input type="text" class="form-control" id="title" name="title" value="<?= $question['title'] ?>"
                                    placeholder="عنوان سوال">
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label">متن سوال</label>
                                <textarea name="body" class="form-control" id="exampleFormControlTextarea1" rows="3"><?= $question['body'] ?></textarea>
                            </div>
                            <div class="mb-3">
                                <select class="js-example-basic-multiple form-select" name="tags[]" multiple="multiple">
                                    <?php $question_tag_ids = array_column($question_tags, 'tag_id'); ?>

                                    <?php
                                    foreach ($tags as $tag) { ?>
                                        <option <?php if(in_array($tag['id'], $question_tag_ids)) echo 'selected'; ?>  value="<?= $tag['id'] ?>"><?= $tag['name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <div class="custom-file">
                                    <input type="file" name="image" class="form-control" id="image">
                                    <label class="custom-file-label" for="image">انتخاب کنید</label>
                                </div>
                                <?php if ($question['image']) { ?>
                                    <img class="mt-3" src="<?= asset($question['image']) ?>" alt="image" width="100" height="100">
                                <?php } ?>
                            </div>
                        </div>
                        <div class="">
                            <a href="<?= url('user/panel') ?>" class="btn btn-secondary">برگشت</a>
                            <button type="submit" class="btn btn-primary">آپدیت</button>
                        </div>
                    </form>
                </div>

            </div>

        </div>
    </div>

    <?php require_once BASE_PATH . '/template/app/layout/scripts.php' ?>
</body>

</html>