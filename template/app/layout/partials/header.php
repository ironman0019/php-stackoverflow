<nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="<?= url('/') ?>">پرسش و پاسخ</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon" style="color: #fff;"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?= url('/') ?>">خانه</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= url('question/all/tags') ?>">برچسب‌ها</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">کاربران</a>
                    </li>
                </ul>
                <form class="d-flex me-3" action="<?= url('search') ?>" method="POST">
                    <input class="form-control me-2" type="text" placeholder="جستجو..." aria-label="Search" name="search">
                    <button class="btn btn-outline-light" type="submit">جستجو</button>
                </form>
                <div class="auth-buttons">
                    <?php if(!isset($_SESSION['user'])) { ?>
                        <a href="<?= url('login') ?>" class="btn btn-outline-light">ورود</a>
                        <a href="<?= url('register') ?>" class="btn btn-light">ثبت‌نام</a>
                    <?php } else { ?>
                        <a href="<?= url('logout') ?>" class="btn text-light btn-outline-danger">خروج</a>
                        <a href="<?= url('user/panel') ?>" class="btn text-light btn-outline-primary">پنل کاربر</a>
                        <?php $user = getUserInfo(); if($user['type'] == 1) { ?>
                            <a href="<?= url('admin') ?>" class="btn btn-outline-info">پنل ادمین</a>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </nav>