<?php

use Activities\Auth\Auth;
use Database\CreateDB;
use Database\Database;
use Parsidev\Jalali\jDate;


session_start();


define('BASE_PATH', __DIR__);
define('BASE_URL', 'http://localhost/php-stackoverflow/');
define('CURRENT_DOMIN', currentDomin() . '/php-stackoverflow/');
define('DISPLAY_ERROR', true);
define('DB_HOST', 'localhost');
define('DB_NAME', 'php-stackoverflow');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');



// mail config
define('MAIL_HOST', 'smtp.gmail.com');
define('SMTP_AUTH', true);
define('MAIL_USERNAME', 'Your username');
define('MAIL_PASSWORD', 'Your app password');
define('MAIL_PORT', '587');
define('SENDER_MAIL', 'Your email');
define('SENDER_NAME', 'StackOverFlow-Project');




// requaire
require_once './database/Database.php';
require_once './database/Create.DB.php';

// $database = new Database;
// $users = $database->delete('users', 2);
// dd($users);

// $db = new CreateDB();
// $db->run();




// Autoload
spl_autoload_register(function($className) {

    $paths = [str_replace('\\', '/', $className).'.php', "lib/$className.php"];

    foreach($paths as $path) {
        if (file_exists($path)) {
            include $path;
        }
    }

    // $path = BASE_PATH . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR;
    // include $path . $className . '.php';
});



// Testing sending mail
// $auth = new Auth();
// $auth->sendMail('emad.doc0019@gmail.com', 'تست', '<p> Hello my dear :) </p>');


// Routeing system
function uri($reservedUrl, $class, $method, $requestMethod = "GET")
{
    // current url
    $currentUrl = explode('?', currentUrl())[0];
    $currentUrl = str_replace(CURRENT_DOMIN, "", $currentUrl);
    $currentUrl = trim($currentUrl, '/ ');
    $currentUrlArray = explode('/', $currentUrl);
    $currentUrlArray = array_filter($currentUrlArray);

    



    // reserved url
    $reservedUrl = trim($reservedUrl, '/ ');
    $reservedUrlArray = explode('/', $reservedUrl);
    $reservedUrlArray = array_filter($reservedUrlArray);


    if(sizeof($currentUrlArray) != sizeof($reservedUrlArray) || methodField() != $requestMethod) {
        return false;
    }


    $parameters = [];

    for($key=0; $key < sizeof($currentUrlArray); $key++) {
        if($reservedUrlArray[$key][0] == "{" && $reservedUrlArray[$key][strlen($reservedUrlArray[$key]) - 1] == "}") {
            array_push($parameters, $currentUrlArray[$key]);
        } elseif($currentUrlArray[$key] !== $reservedUrlArray[$key]) {
            return false;
        }
    }

    // Create $request
    if(methodField() == 'POST') {
        $request = isset($_FILES) ? array_merge($_POST, $_FILES) : $_POST;
        $parameters = array_merge([$request], $parameters);
    }


    // Create obj of class
    $object = new $class;
    call_user_func_array([$object, $method], $parameters);
    exit();
}




function asset($src)
{
    $domin = trim(CURRENT_DOMIN, '/ ');
    $src = $domin . '/' . trim($src, '/ ');
    return $src;
}


function redirect($url)
{
    header("Location:" . trim(BASE_URL, '/') . '/' . trim($url, '/'));
    exit();
}


function redirectBack()
{
    header("Location:" . $_SERVER['HTTP_REFERER']);
    exit();
}



function url($url)
{
    $domin = trim(CURRENT_DOMIN, '/ ');
    $url = $domin . '/' . trim($url, '/ ');
    return $url;
}



function protocol()
{
    return stripos($_SERVER['SERVER_PROTOCOL'], 'https')  === true ? 'https://' : 'http://';
}



function currentDomin()
{
    return protocol() . $_SERVER['HTTP_HOST'];
}



function currentUrl()
{
    return currentDomin() . $_SERVER['REQUEST_URI'];
}



function methodField()
{
    return $_SERVER['REQUEST_METHOD'];
}



function displayError($status)
{
    if($status)
    {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    } 
    else 
    {
        ini_set('display_errors', 0);
        ini_set('display_startup_errors', 0);
        error_reporting(0);
    }
}

displayError(DISPLAY_ERROR);



function dd($var)
{
    echo '<pre/>';
    var_dump($var);
    exit;
}


global $flashMessage;

if(isset($_SESSION['flash_message'])) {
    $flashMessage = $_SESSION['flash_message'];
    unset($_SESSION['flash_message']);
}

function flash($name, $value = null)
{
    //getter
    if($value === null)
    {
        global $flashMessage;
        $message = isset($flashMessage[$name]) ? $flashMessage[$name] : "";
        return $message;
    }
    //setter
    else 
    {
        $_SESSION['flash_message'][$name] = $value;
    }
}



function jalali($date)
{
    return jDate::forge($date)->format('%B %d، %Y');
}


function filterHtmlSpecialChars($array) {
    return array_map(function($value) {
        // If the value is an array, apply the function recursively
        if (is_array($value)) {
            return filterHtmlSpecialChars($value);
        }
        // Otherwise, apply htmlspecialchars to the value
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }, $array);
}


function getUserInfo()
{
    if(!isset($_SESSION['user'])) {
        return null;
    }

    $db = new Database();

    $user = $db->select("SELECT * FROM `users` WHERE `id` = ?;", [$_SESSION['user']])->fetch();

    if(!$user) {
        return null;
    }

    return $user;
}




// Home 
uri('/', 'Activities\App\Home', 'index');
uri('/question/{id}', 'Activities\App\Home', 'question');
uri('/answer/vote/{value}', 'Activities\App\Home', 'answerVote');
uri('/question/vote/{value}', 'Activities\App\Home', 'questionVote');
uri('/answer/accept/{id}', 'Activities\App\Home', 'acceptAnswer');
uri('/answer/comment/{id}', 'Activities\App\Home', 'answerComment', 'POST');
uri('/question/comment/{id}', 'Activities\App\Home', 'questionComment', 'POST');
uri('/question/tag/{id}', 'Activities\App\Home', 'tag');
uri('/question/all/tags', 'Activities\App\Home', 'tags');
uri('/question/store', 'Activities\App\Home', 'storeQuestion', 'POST');
uri('/user/panel', 'Activities\App\Home', 'userPanel');
uri('/question/edit/{id}', 'Activities\App\Home', 'questionEdit');
uri('/question/update/{id}', 'Activities\App\Home', 'questionUpdate', 'POST');
uri('/search', 'Activities\App\Home', 'indexSearch', 'POST');





// Admin
uri('admin', 'Activities\Admin\Dashbord', 'index');

// question
uri('admin/question', 'Activities\Admin\Question', 'index');
uri('admin/question/create', 'Activities\Admin\Question', 'create');
uri('admin/question/store', 'Activities\Admin\Question', 'store', 'POST');
uri('admin/question/edit/{id}', 'Activities\Admin\Question', 'edit');
uri('admin/question/update/{id}', 'Activities\Admin\Question', 'update', 'POST');
uri('admin/question/delete/{id}', 'Activities\Admin\Question', 'delete');


// tag
uri('admin/tag', 'Activities\Admin\Tag', 'index');
uri('admin/tag/create', 'Activities\Admin\Tag', 'create');
uri('admin/tag/store', 'Activities\Admin\Tag', 'store', 'POST');
uri('admin/tag/edit/{id}', 'Activities\Admin\Tag', 'edit');
uri('admin/tag/update/{id}', 'Activities\Admin\Tag', 'update', 'POST');
uri('admin/tag/delete/{id}', 'Activities\Admin\Tag', 'delete');


// question-images
uri('admin/question/{id}/images', 'Activities\Admin\QuestionImage', 'index');
uri('admin/question/{id}/images/create', 'Activities\Admin\QuestionImage', 'create');
uri('admin/question/{id}/images/store', 'Activities\Admin\QuestionImage', 'store', 'POST');
uri('admin/question/{id}/images/edit/{image_id}', 'Activities\Admin\QuestionImage', 'edit');
uri('admin/question/{id}/images/update/{image_id}', 'Activities\Admin\QuestionImage', 'update', 'POST');
uri('admin/question/{id}/images/delete/{image_id}', 'Activities\Admin\QuestionImage', 'delete');


// answers
uri('admin/question/{id}/answers', 'Activities\Admin\Answer', 'index');
uri('admin/question/{id}/answers/create', 'Activities\Admin\Answer', 'create');
uri('admin/question/{id}/answers/store', 'Activities\Admin\Answer', 'store', 'POST');
uri('admin/question/{id}/answers/edit/{answer_id}', 'Activities\Admin\Answer', 'edit');
uri('admin/question/{id}/answers/update/{answer_id}', 'Activities\Admin\Answer', 'update', 'POST');
uri('admin/question/{id}/answers/delete/{answer_id}', 'Activities\Admin\Answer', 'delete');



// comments
uri('admin/comments', 'Activities\Admin\Comment', 'index');
uri('admin/comments/status/{id}', 'Activities\Admin\Comment', 'setStatus');
uri('admin/comments/show/{id}', 'Activities\Admin\Comment', 'show');


// users
uri('admin/users', 'Activities\Admin\User', 'index');
uri('admin/users/edit/{id}', 'Activities\Admin\User', 'edit');
uri('admin/users/update/{id}', 'Activities\Admin\User', 'update', 'POST');
uri('admin/users/delete/{id}', 'Activities\Admin\User', 'delete');
uri('admin/users/type/{id}', 'Activities\Admin\User', 'setType');


// Auth
uri('register', 'Activities\Auth\Auth', 'registerView');
uri('register/store', 'Activities\Auth\Auth', 'registerStore', 'POST');
uri('activation/{token}', 'Activities\Auth\Auth', 'activation');
uri('login', 'Activities\Auth\Auth', 'login');
uri('login/auth', 'Activities\Auth\Auth', 'loginAuth', 'POST');
uri('logout', 'Activities\Auth\Auth', 'logout');
uri('forget_password/view', 'Activities\Auth\Auth', 'forgetPasswordView');
uri('forget_password', 'Activities\Auth\Auth', 'forgetPassword', 'POST');
uri('reset_password/view/{token}', 'Activities\Auth\Auth', 'resetPasswordView');
uri('reset_password/{token}', 'Activities\Auth\Auth', 'resetPassword', 'POST');





echo "404 - not found";
exit();
