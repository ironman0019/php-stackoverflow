<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <title>سوالات مربوط به تگ</title>

    <?php require_once BASE_PATH . '/template/app/layout/head-tag.php' ?>

</head>

<body>

    <?php require_once BASE_PATH . '/template/app/layout/partials/header.php' ?>


    <div class="container mt-4">
        <div class="row">
            <div class="col-lg-9 col-md-12">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3>سوالات مربوط به تگ : <?= $tag['name'] ?></h3>
                </div>
                <?php if (flash('alert')) { ?>
                    <div class="mb-2 alert alert-danger"> <small class="form-text text-danger"><?= flash('alert') ?></small> </div>
                <?php } ?>
                <?php if (flash('success')) { ?>
                    <div class="mb-2 alert alert-success"> <small class="form-text text-success"><?= flash('success') ?></small> </div>
                <?php } ?>
                <?php foreach($questions as $question) { ?>
                    <div class="question-summary">
                        <div class="stats d-none d-md-block">
                            <div class="stat-item">
                                <div class="count">
                                <?php 
                                    if($question['votes'] !== null) {
                                        $votes = explode(',', $question['votes']);
                                        $votes = array_map('intval', $votes);  // Cast all values in the array to integers
                                        $votes_counts = array_count_values($votes);
                                        $count_of_zeros = isset($votes_counts[0]) ? $votes_counts[0] : 0;
                                        $count_of_ones = isset($votes_counts[1]) ? $votes_counts[1] : 0;
                                        if($count_of_zeros > $count_of_ones) {
                                            echo $count_of_zeros - $count_of_ones . '+';
                                        } elseif($count_of_ones > $count_of_zeros) {
                                            echo $count_of_ones - $count_of_zeros . '-';
                                        } elseif($count_of_zeros == $count_of_ones) {
                                            echo '0';
                                        }
                                    } else {
                                        echo '0';
                                    }
                                ?>
                                </div>
                                <div class="label">رای</div>
                            </div>
                            <div class="stat-item">
                                <div class="count">
                                    <?php 
                                        if($question['answers']) {
                                            $answers = explode(',', $question['answers']); echo count($answers);
                                        } else {
                                            echo '0';
                                        }
                                    ?>
                                </div>
                                <div class="label">پاسخ</div>
                            </div>
                            <div class="stat-item">
                                <div class="count"><?= $question['view'] ? $question['view'] : 0 ?></div>
                                <div class="label">بازدید</div>
                            </div>
                        </div>
                        <div class="question-details my-3">
                            <a href="<?= url('question/' . $question['id']) ?>" class="question-title"><?= $question['title'] ?></a>
                            <div class="question-meta mt-2">پرسیده شده توسط <strong><?= $question['username'] ?></strong><?=" " . jalali($question['created_at']) ?></div>
                        </div>
                    </div>
                <?php } ?>
                
            </div>

            <?php require_once BASE_PATH . '/template/app/layout/partials/sidebar.php' ?>

        </div>
    </div>

    <?php require_once BASE_PATH . '/template/app/layout/scripts.php' ?>
</body>

</html>