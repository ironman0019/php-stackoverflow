<!DOCTYPE html>
<html lang="en">

<head>
    <title>Reset Password</title>
    <?php require_once BASE_PATH . '/template/auth/layout/head-tag.php' ; ?>
</head>

<body>

    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="login100-pic js-tilt" data-tilt>
                    <img src="<?= asset('public/auth-assets/images/img-01.png') ?>" alt="IMG">
                </div>

                <form method="post" action="<?= url('reset_password/' . $token) ?>" class="login100-form validate-form">
                    <span class="login100-form-title">
                        Reset Password
                    </span>

                    <?php if(flash('reset_password_error')) { ?>
                        <div class="mb-2 alert alert-danger"> <small class="form-text text-danger"><?= flash('reset_password_error') ?></small> </div>
                    <?php } ?>


                    <div class="wrap-input100 validate-input" data-validate="Password is required">
                        <input class="input100" type="password" name="password" placeholder="New Password">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                        </span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Password is required">
                        <input class="input100" type="password" name="password_confirmation" placeholder="Re enter Password">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                        </span>
                    </div>

                    <div class="container-login100-form-btn">
                        <button type="submit" class="login100-form-btn">
                            Send
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
                        <a class="txt2" href="<?= url('login') ?>">
                            Login your Account
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