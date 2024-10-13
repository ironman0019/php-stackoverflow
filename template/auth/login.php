<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login</title>
    <?php require_once BASE_PATH . '/template/auth/layout/head-tag.php' ; ?>
</head>

<body>

    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="login100-pic js-tilt" data-tilt>
                    <img src="<?= asset('public/auth-assets/images/img-01.png') ?>" alt="IMG">
                </div>

                <form method="post" action="<?= url('login/auth') ?>" class="login100-form validate-form">
                    <span class="login100-form-title">
                        Login
                    </span>

                    <?php if(flash('login_error')) { ?>
                        <div class="mb-2 alert alert-danger"> <small class="form-text text-danger"><?= flash('login_error') ?></small> </div>
                    <?php } ?>


                    <div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
                        <input class="input100" type="text" name="email" placeholder="Email">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                        </span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Password is required">
                        <input class="input100" type="password" name="password" placeholder="Password">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                        </span>
                    </div>

                    <div class="container-login100-form-btn">
                        <button type="submit" class="login100-form-btn">
                            Login
                        </button>
                    </div>

                    <div class="text-center p-t-12">
                        <span class="txt1">
                            Forgot
                        </span>
                        <a class="txt2" href="<?= url('forget_password/view') ?>">
                            Username / Password?
                        </a>
                    </div>

                    <div class="text-center p-t-136">
                        <a class="txt2" href="<?= url('register') ?>">
                            Register
                            <i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <?php require_once BASE_PATH . '/template/auth/layout/scripts.php' ;?>

</body>

</html>