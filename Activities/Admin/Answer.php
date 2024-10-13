<?php

namespace Activities\Admin;

use Activities\Services\ImageService;
use Database\Database;

class Answer extends Admin {

    public function index($id)
    {
        $db = new Database();
        $question = $db->select("SELECT * FROM `questions` WHERE id = ?;", [$id])->fetch();
        $answers = $db->select("SELECT `answers`.* , `users`.`username` AS username FROM `answers` INNER JOIN `users` ON `answers`.`user_id` = `users`.`id` WHERE `question_id` = ?;", [$id])->fetchAll();
        require_once BASE_PATH . '/template/admin/answer/index.php';
    }

    public function create($id)
    {
        $db = new Database();
        $users = $db->select("SELECT * FROM `users`;")->fetchAll();
        $question = $db->select("SELECT * FROM `questions` WHERE id = ?;", [$id])->fetch();
        require_once BASE_PATH . '/template/admin/answer/create.php';
    }

    public function store($request, $id)
    {
        $db = new Database();

        $request = filterHtmlSpecialChars($request);

        if(empty($request['body'])) {
            flash('create_answer_error', 'لطفا همه فیلد ها را پر کنید');
            redirectBack();

        } else {
            $request['question_id'] = $id;

            // store answer
            $db->insert('answers', array_keys($request), $request);
    
            redirect('admin/question/' . $id . '/answers');
        }

    }

    public function edit($id, $answer_id)
    {
        $db = new Database();
        $question = $db->select("SELECT * FROM `questions` WHERE id = ?;", [$id])->fetch();
        $answer = $db->select("SELECT * FROM `answers` WHERE id = ?;", [$answer_id])->fetch();
        $users = $db->select("SELECT * FROM `users`;")->fetchAll();
        require_once BASE_PATH . '/template/admin/answer/edit.php';
    }

    public function update($request, $id, $answer_id)
    {
        $db = new Database();

        $request = filterHtmlSpecialChars($request);

        if(empty($request['body'])) {
            flash('edit_answer_error', 'لطفا همه فیلد ها را پر کنید');
            redirectBack();

        } else {
            // question id
            $request['question_id'] = $id;

            // Update answer
            $db->update('answers', $answer_id, array_keys($request), $request);

            redirect('admin/question/' . $id . '/answers');
        }

    }

    public function delete($id, $answer_id)
    {
        $db = new Database();

        $db->delete('answers', $answer_id);
        redirect('admin/question/' . $id . '/answers');
    }
}