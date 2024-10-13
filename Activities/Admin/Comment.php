<?php

namespace Activities\Admin;

use Database\Database;

class Comment extends Admin {

    public function index()
    {
        $db = new Database();
        $comments = $db->select("SELECT `comments`.*, `users`.`username` AS username, `questions`.`title` AS question_title, `answers`.`body` AS answer_title FROM `comments` INNER JOIN `users` ON `comments`.`user_id` = `users`.`id` LEFT JOIN `questions` ON `comments`.`question_id` = `questions`.`id` LEFT JOIN `answers` ON `comments`.`answer_id` = `answers`.`id`;")->fetchAll();
        require_once BASE_PATH . '/template/admin/comment/index.php';
    }

    public function setStatus($id)
    {
        $db = new Database();
        $comment = $db->select("SELECT * FROM `comments` WHERE id = ?;", [$id])->fetch();

        if($comment['status'] == 0) {
            $db->update('comments', $id, ['status'], [1]);
        } else {
            $db->update('comments', $id, ['status'], [0]);
        }

        redirect('admin/comments');
    }

    public function show($id)
    {
        $db = new Database();
        $comment = $db->select("SELECT `comments`.*, `users`.`username` AS username, `questions`.`body` AS question_body, `answers`.`body` AS answer_body FROM `comments` INNER JOIN `users` ON `comments`.`user_id` = `users`.`id` LEFT JOIN `questions` ON `comments`.`question_id` = `questions`.`id` LEFT JOIN `answers` ON `comments`.`answer_id` = `answers`.`id` WHERE `comments`.`id` = ?;", [$id])->fetch();
        require_once BASE_PATH . '/template/admin/comment/show.php';
    }

}