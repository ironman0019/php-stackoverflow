<div class="col-lg-3 col-md-12">
    <div class="sidebar-section">
        <h5>برچسب‌های پرکاربرد</h5>
        <div>
            <?php foreach($popularTags as $popularTag) { ?>
                <a href="<?= url('question/tag/' . $popularTag['id']) ?>" class="badge-tag"><?= $popularTag['name'] ?></a>
            <?php } ?>
        </div>
    </div>

    <div class="sidebar-section">
        <h5>سوالات پربازدید</h5>
        <ul class="list-group">
            <?php foreach($mostViewedQuestions as $mostViewedQuestion) { ?>
                <li class="list-group-item"><a href="<?= url('question/' . $mostViewedQuestion['id'])?>"><?= $mostViewedQuestion['title'] ?></a></li>
            <?php } ?>
        </ul>
    </div>

    <div class="sidebar-section">
        <h5>کاربران فعال</h5>
        <ul class="list-group">
            <?php foreach($activeUsers as $activeUser) { ?>
                <li class="list-group-item"><a href="#"><?= $activeUser['username'] ?></a></li>
            <?php } ?>
        </ul>
    </div>
</div>