<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <title>برچسب ها</title>

    <?php require_once BASE_PATH . '/template/app/layout/head-tag.php' ?>

</head>

<body>

    <?php require_once BASE_PATH . '/template/app/layout/partials/header.php' ?>


    <div class="container mt-4">
        <div class="row">
            <div class="col-lg-9 col-md-12">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3>همه برچسب ها</h3>
                </div>
                <?php if (flash('alert')) { ?>
                    <div class="mb-2 alert alert-danger"> <small class="form-text text-danger"><?= flash('alert') ?></small> </div>
                <?php } ?>
                <?php if (flash('success')) { ?>
                    <div class="mb-2 alert alert-success"> <small class="form-text text-success"><?= flash('success') ?></small> </div>
                <?php } ?>
                
                <?php foreach($tags as $tag) { ?>
                    <a href="<?=url('question/tag/'.$tag['id'])?>"class="badge-tag"><?= $tag['name'] ?></a>
                <?php } ?>
                
            </div>

            <?php require_once BASE_PATH . '/template/app/layout/partials/sidebar.php' ?>

        </div>
    </div>

    <?php require_once BASE_PATH . '/template/app/layout/scripts.php' ?>
</body>

</html>