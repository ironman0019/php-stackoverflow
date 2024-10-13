<!DOCTYPE html>
<html lang="en">

<head>
    <title>Forget Password</title>
    <?php require_once BASE_PATH . '/template/auth/layout/head-tag.php' ; ?>
</head>

<body>

    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="login100-pic js-tilt" data-tilt>
                    <img src="<?= asset('public/auth-assets/images/img-01.png') ?>" alt="IMG">
                </div>
                
                <?php if(!isset($_SESSION['sent_email'])) { ?>
                <form method="post" action="<?= url('forget_password') ?>" class="login100-form validate-form">
                    <span class="login100-form-title">
                        Forget Password
                    </span>

                    <?php if(flash('forget_password_error')) { ?>
                        <div class="mb-2 alert alert-danger"> <small class="form-text text-danger"><?= flash('forget_password_error') ?></small> </div>
                    <?php } ?>


                    <div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
                        <input class="input100" type="text" name="email" placeholder="Email">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                        </span>
                    </div>


                    <div class="container-login100-form-btn">
                        <button type="submit" class="login100-form-btn">
                            Send
                        </button>
                    </div>


                    <div class="text-center p-t-136">
                        <a class="txt2" href="<?= url('register') ?>">
                            Create your Account
                            <i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
                        </a>
                    </div>
                </form>
                <?php } else { ?>
                    <div>
                        <p>The reset password email has been sent! check your email inbox.</p>
                    </div>
                    <?php unset($_SESSION['sent_email']); ?>
                <?php } ?>
            </div>
        </div>
    </div>



    <?php require_once BASE_PATH . '/template/auth/layout/scripts.php' ;?>

</body>

</html>