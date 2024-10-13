<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <title>نمایش سوال</title>

    <?php require_once BASE_PATH . '/template/app/layout/head-tag.php' ?>
</head>

<body>

    <?php require_once BASE_PATH . '/template/app/layout/partials/header.php' ?>


    <div class="container mt-4">
        <div class="row">
            <div class="col-lg-9 col-md-12">
                <div class="question-section">
                    <?php if (flash('alert')) { ?>
                        <div class="mb-2 alert alert-danger"> <small class="form-text text-danger"><?= flash('alert') ?></small> </div>
                    <?php } ?>
                    <?php if (flash('success')) { ?>
                        <div class="mb-2 alert alert-success"> <small class="form-text text-success"><?= flash('success') ?></small> </div>
                    <?php } ?>
                    <h3 class="question-title"><?= $question['title'] ?></h3>
                    <div class="question-meta">
                        <span><?= 'پرسیده شده توسط' . $question['username'] . 'در' . jalali($question['created_at']) ?></span> |
                        <span>
                            <?php
                            if ($question['votes'] !== null) {
                                $votes = explode(',', $question['votes']);
                                $votes = array_map('intval', $votes);  // Cast all values in the array to integers
                                $votes_counts = array_count_values($votes);
                                $count_of_zeros = isset($votes_counts[0]) ? $votes_counts[0] : 0;
                                $count_of_ones = isset($votes_counts[1]) ? $votes_counts[1] : 0;
                                if ($count_of_zeros > $count_of_ones) {
                                    echo $count_of_zeros - $count_of_ones . '+';
                                } elseif ($count_of_ones > $count_of_zeros) {
                                    echo $count_of_ones - $count_of_zeros . '-';
                                } elseif ($count_of_zeros == $count_of_ones) {
                                    echo '0';
                                }
                            } else {
                                echo '0';
                            }
                            ?>
                            رای
                        </span> |
                        <span><?= $question['view'] ? $question['view'] . " " . 'بازدید' : 0 . " " . 'بازدید' ?></span>
                    </div>
                    <div class="question-body">
                        <p>
                            <?= $question['body'] ?>
                        </p>
                        <img src="<?= $question['image'] ? asset($question['image']) : 'https://via.placeholder.com/600x300' ?>" alt="<?= $question['title'] ?>" class="img-fluid rounded" width="600" height="300">
                        <div class="d-flex mt-3 gap-2">
                            <?php if ($question_images) {
                                foreach ($question_images as $question_image) { ?>
                                    <img src="<?= $question_image['image'] ? asset($question_image['image']) : 'https://via.placeholder.com/150x100' ?>" alt="<?= $question['title'] ?>" class="img-fluid rounded" width="150" height="100">
                            <?php }
                            } ?>
                        </div>

                    </div>
                    <div class="question-tags">
                        <?php
                        if ($question['tags']) {
                            $tags = explode(',', $question['tags']);
                            $tagIds = explode(',', $question['tagIds']);
                        ?>
                            <?php
                            foreach ($tags as $index => $tag) {
                                $tagId = $tagIds[$index];
                            ?>
                                <a href="<?= url('question/tag/' . $tagId) ?>" class="badge-tag mb-2"><?= $tag ?></a>
                        <?php }
                        } else {
                            echo "";
                        } ?>
                    </div>
                    <div class="vote-buttons">
                        <button class="bg-white border-0 question_like_vote" value="<?= $question['id'] . ",0" ?>"><i class='bx bx-like'></i></button>
                        <button class="bg-white border-0 question_dislike_vote" value="<?= $question['id'] . ",1" ?>"><i class='bx bx-dislike'></i></button>
                    </div>
                </div>



                <h4>پاسخ‌ها (<?= count($answers) ?>)</h4>


                <?php foreach ($answers as $answer) { ?>

                    <?php $total_votes = ($answer['up_votes'] ?? 0) - ($answer['down_votes'] ?? 0) ?>

                    <div class="answer-section <?= $answer['is_accepted'] ? 'accepted' : '' ?>">
                        <div class="vote-buttons">
                            <button class="bg-white border-0 answer_like_vote" value="<?= $answer['id'] . ",0" ?>"><i class='bx bx-like'></i></button>
                            <div class="count"><?= $total_votes ?></div>
                            <button class="bg-white border-0 answer_dislike_vote" value="<?= $answer['id'] . ",1" ?>"><i class='bx bx-dislike'></i></button>
                        </div>
                        <p class="mt-1">
                            <?= $answer['body'] ?>
                        </p>
                        <small class="text-sm text-secondary">- <?= $answer['username'] ?> در <?= jalali($answer['created_at']) ?></small>
                        <?php if (isset($_SESSION['user'])) { ?>
                            <?php if ($question['user_id'] == $_SESSION['user'] && $answer['is_accepted'] == 0) { ?>
                                <div>
                                    <a href="<?= url('answer/accept/' . $answer['id']) ?>" class="btn"><span class="approve-answer">تایید به عنوان پاسخ صحیح</span></a>
                                </div>
                        <?php }
                        } ?>
                        <?php if (isset($_SESSION['user'])) { ?>
                            <div class="add-comment">
                                <h6>افزودن نظر</h6>
                                <form action="<?= url('answer/comment/' . $answer['id']) ?>" method="POST">
                                    <div class="mb-3">
                                        <textarea class="form-control" rows="3" placeholder="نظر خود را بنویسید..." name="body"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">ارسال نظر</button>
                                </form>
                            </div>
                        <?php } ?>
                        <div class="comments-section">
                            <h6>نظرات</h6>
                            <?php foreach ($answer_comments as $answer_comment) { ?>
                                <?php if ($answer['id'] == $answer_comment['answer_id']) { ?>
                                    <div class="comment-item">
                                        <p> <?= $answer_comment['body'] ?> <small>- <?= $answer_comment['username'] ?> در <?= jalali($answer_comment['created_at']) ?></small></p>
                                    </div>
                            <?php }
                            } ?>
                        </div>
                    </div>
                <?php } ?>

                <div class="answer-section">
                    <div class="comments-section">
                        <h5>نظرات سوال</h5>
                        <?php foreach ($question_comments as $question_comment) { ?>
                            <div class="comment-item">
                                <p><?= $question_comment['body'] ?> <small>- <?= $question_comment['username'] ?> در <?= jalali($question_comment['created_at']) ?></small></p>
                            </div>
                        <?php } ?>
                    </div>
                    <?php if (isset($_SESSION['user'])) { ?>
                        <div class="add-comment">
                            <h6>افزودن نظر</h6>
                            <form action="<?= url('question/comment/' . $question['id']) ?>" method="POST">
                                <div class="mb-3">
                                    <textarea class="form-control" rows="3" placeholder="نظر خود را بنویسید..." name="body"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">ارسال نظر</button>
                            </form>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <?php require_once BASE_PATH . '/template/app/layout/partials/sidebar.php' ?>

        </div>
    </div>

    <?php require_once BASE_PATH . '/template/app/layout/scripts.php' ?>
</body>

</html>