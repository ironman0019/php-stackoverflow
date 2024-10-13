<?php

namespace Activities\Auth;

use Database\Database;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class Auth {

    public function registerView()
    {
        require_once BASE_PATH . '/template/auth/register.php';
    }

    public function registerStore($request)
    {
        $request = filterHtmlSpecialChars($request);
        
        if(empty($request['username']) || empty($request['email']) || empty($request['password'])) {
            
            flash('register_error', 'لطفا همه فیلد ها را پر کنید');
            redirectBack();

        } elseif(strlen($request['password']) < 8) {

            flash('register_error', 'رمز عبور نباید کم تر از 8 کاراکتر باشد');
            redirectBack();

        } elseif(!filter_var($request['email'], FILTER_VALIDATE_EMAIL)) {
            
            flash('register_error', 'ایمیل وارد شده معتبر نمیباشد');
            redirectBack();

        } elseif($request['password'] !== $request['password_confirmation']) {

            flash('register_error', 'رمز عبور مطابقت ندارد');
            redirectBack();

        } else {
            $db = new Database();
            $user = $db->select("SELECT * FROM `users` WHERE `email` = ?;", [$request['email']])->fetch();

            if($user) {

                flash('register_error', 'ایمیل وارد شده تکراری میباشد');
                redirectBack();

            } else {
                $randomToken = $this->randomToken();
                $activationMessage = $this->activationMessage($request['username'], $randomToken);
                $resault = $this->sendMail($request['email'], 'فعال سازی حساب کاربری', $activationMessage);
                $request['password'] = $this->hashPassword($request['password']);

                if($resault) {
                    // Store user
                    $db->insert('users', ['username', 'email', 'password', 'verify_token'], [$request['username'], $request['email'], $request['password'], $randomToken]);

                    redirect('login');

                } else {
                    flash('register_error', 'ایمیل ارسال نشد');
                    redirectBack();
                }
            }
        }
    }

    public function login()
    {
        require_once BASE_PATH . '/template/auth/login.php';
    }


    public function loginAuth($request)
    {
        if(!empty($request['email'] || !empty($request['password']))) {

            $db = new Database();
            $user = $db->select("SELECT * FROM `users` WHERE `email` = ?;", [$request['email']])->fetch();

            if($user) {
                if(password_verify($request['password'], $user['password'])) {

                    if($user['status'] == 1) {

                        $_SESSION['user'] = $user['id'];
                        redirect('admin');

                    } else {

                        flash('login_error', 'کاربر فعال نیست!');
                        redirectBack();
                    }

                } else {

                    flash('login_error', 'اطلاعات وارد شده صحیح نیست');
                    redirectBack();
                }

            } else {

                flash('login_error', 'اطلاعات وارد شده صحیح نیست');
                redirectBack();
            }

        } else {

            flash('login_error', 'لطفا همه فیلد ها را پر کنید');
            redirectBack();
        }
    }


    public function logout()
    {
        if(!isset($_SESSION['user'])) {
            redirect('login');
        }

        session_destroy();
        redirect('/');
    }


    public function activation($token)
    {
        $db = new Database();
        $user = $db->select("SELECT * FROM `users` WHERE verify_token = ?;", [$token])->fetch();

        if($user == null) {
            flash('login_error', 'کاربر یافت نشد');
            redirect('login');
        } else {
            $resault = $db->update('users', $user['id'], ['status'], [1]);
            flash('login_error', 'حساب شما فعال شد');
            redirect('login');
        }
        
    }

    public function forgetPasswordView()
    {
        require_once BASE_PATH . '/template/auth/forgetPassword.php';
    }


    public function forgetPassword($request)
    {
        if(empty($request['email'])) {

            flash('forget_password_error', 'لطفا همه فیلد ها را پر کنید');
            redirectBack();

        } else {

            $db = new Database();
            $user = $db->select("SELECT * FROM `users` WHERE `email` = ?;", [$request['email']])->fetch();

            if($user) {
                $randomToken = $this->randomToken();
                $forgetPasswordMessage = $this->forgetPasswordMessage($randomToken);
                $resault = $this->sendMail($request['email'], 'فراموشی رمز عبور', $forgetPasswordMessage);
                date_default_timezone_set('Asia/Tehran');
                $token_expire = date('Y-m-d H:i:s', strtotime("+5 min"));
                

                if($resault) {
                    // Update user forget token
                    $db->update('users', $user['id'], ['forget_token', 'forget_token_expire'], [$randomToken, $token_expire]);

                    $_SESSION['sent_email'] = true;

                    redirectBack();

                } else {
                    flash('forget_password_error', 'ایمیل ارسال نشد :(');
                    redirectBack();
                }

            } else {
                flash('forget_password_error', 'کاربر یافت نشد');
                redirectBack();
            }
        }
    }


    public function resetPasswordView($token)
    {
        require_once BASE_PATH . '/template/auth/resetPassword.php';
    }


    public function resetPassword($request, $token)
    {
        date_default_timezone_set('Asia/Tehran');

        if(empty($request['password']) || empty($request['password_confirmation'])) {
            flash('reset_password_error', 'لطفا همه فیلد ها را پر کنید');
            redirectBack();

        } elseif(strlen($request['password']) < 8) {
            flash('reset_password_error', 'رمز عبور نباید کم تر از 8 کاراکتر باشد');
            redirectBack();

        } elseif($request['password'] !== $request['password_confirmation']) {
            flash('reset_password_error', 'رمز عبور مطابقت ندارد');
            redirectBack();

        } else {
            $db = new Database();
            $user = $db->select("SELECT * FROM `users` WHERE forget_token = ?;", [$token])->fetch();
    
            if(!$user) {
                flash('login_error', 'کاربر یافت نشد');
                redirect('login');
    
            } elseif($user['forget_token_expire'] < date('Y-m-d H:i:s')) {
                flash('login_error', 'لینک منقضی شده است');
                redirect('login');
    
            } else {
                $request['password'] = $this->hashPassword($request['password']);
                $resault = $db->update('users', $user['id'], ['password'], [$request['password']]);
                flash('login_error', 'رمز عبور آپدیت شد');
                redirect('login');
            }
        }
    }


    public function checkAdmin()
    {
        if(isset($_SESSION['user'])) {

            $db = new Database();
            $user = $db->select("SELECT * FROM `users` WHERE `id` = ?;", [$_SESSION['user']])->fetch();

            if($user) {

                if($user['type'] == 0) {
                    redirect('/');
                }

            } else {
                flash('login_error', 'کاربر یافت نشد');
                redirect('login');
            }

        } else {
            flash('login_error', 'ابتدا وارد شوید');
            redirect('login');
        }
    }

    
    private function hashPassword($password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        return $hashedPassword;
    }

    private function randomToken()
    {
        return bin2hex(openssl_random_pseudo_bytes(32));
    }


    
    private function sendMail($emailAddress, $subject, $body)
    {
        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);
        
        try {
            //Server settings
            $mail->CharSet = 'UTF-8';
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = MAIL_HOST;                     //Set the SMTP server to send through
            $mail->SMTPAuth   = SMTP_AUTH;                                   //Enable SMTP authentication
            $mail->Username   = MAIL_USERNAME;                     //SMTP username
            $mail->Password   = MAIL_PASSWORD;                               //SMTP password
            $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
            $mail->Port       = MAIL_PORT;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        
            //Recipients
            $mail->setFrom(SENDER_MAIL, SENDER_NAME);
            $mail->addAddress($emailAddress);     //Add a recipient
        
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $body;
        
            $mail->send();
            echo 'Message has been sent';
            return true;
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            return false;
        }
    }


    private function activationMessage($username, $token)
    {
        $message = '
            <h1>فعال سازی حساب</h1>
            <p>' .$username . 'عزیز برای فعال سازی حساب کاربری روی لینک زیر کلیک کن</p>
            <a href=" ' . url('activation') . '/' . $token . ' ">لینک فعال سازی</a>
        ' ;
        return $message;
    }


    private function forgetPasswordMessage($token)
    {
        $message = '
        <h1>فراموشی رمز عبور</h1>
        <h2>اگر شما درخواست فراموشی رمز خود را ندادید این پیام را نادیده بگیرید</h2>
        <p>برای ریست کردن رمز عبور خود روی لینک زیر کلیک کنید.</p>
        <a href=" ' . url('reset_password') . '/view/' . $token . ' ">لینک</a>
    ';
        return $message;
    }



}