<?php

namespace Activities\Admin;

use Activities\Services\ImageService;
use Database\Database;

class Question extends Admin {

    public function index()
    {
        $db = new Database();
        $questions = $db->select("SELECT `questions`.* , `users`.`username` AS username, GROUP_CONCAT(`tags`.`name` SEPARATOR ', ') AS tags FROM `questions` INNER JOIN `users` ON `questions`.`user_id` = `users`.`id` LEFT JOIN `question_tag` ON `questions`.`id` = `question_tag`.`question_id` LEFT JOIN `tags` ON `question_tag`.`tag_id` = `tags`.`id` GROUP BY `questions`.`id`;")->fetchAll();
        require_once BASE_PATH . '/template/admin/questions/index.php';
    }

    public function create()
    {
        $db = new Database();
        $users = $db->select("SELECT * FROM `users`;")->fetchAll();
        $tags = $db->select("SELECT * FROM `tags`;")->fetchAll();
        require_once BASE_PATH . '/template/admin/questions/create.php';
    }

    public function store($request)
    {
        $db = new Database();

        $request = filterHtmlSpecialChars($request);

        // For images
        $allowedType = ['image/png', 'image/jpg', 'image/jpeg', 'image/gif', ''];

        if(empty($request['title']) || empty($request['body'] || empty($request['tags']))) {
            flash('create_question_error', 'لطفا همه فیلد ها را پر کنید');
            redirectBack();


        } elseif(!in_array($request['image']['type'], $allowedType)) {
            flash('create_question_error', 'لطفا عکس وارد کنید');
            redirectBack();

        } else {
            // tags
            $tags = $request['tags'];
            unset($request['tags']);

            // Image
            $imageService = new ImageService();
            $resault = $imageService->saveImage($request['image'], 'images');

            if ($resault) {
                $request['image'] = $resault;
            } else {
                unset($request['image']);
            }

            // store question
            $questionId = $db->insert('questions', array_keys($request), $request);

            foreach ($tags as $tagId) {
                $db->insert('question_tag', ['question_id', 'tag_id'], [$questionId, $tagId]);
            }

            redirect('admin/question');
        }


    }

    public function edit($id)
    {
        $db = new Database();
        $question = $db->select("SELECT * FROM `questions` WHERE id = ?;", [$id])->fetch();
        $users = $db->select("SELECT * FROM `users`;")->fetchAll();
        $tags = $db->select("SELECT * FROM `tags`;")->fetchAll();
        $question_tags = $db->select("SELECT `tag_id` FROM `question_tag` WHERE `question_id` = ?;", [$id])->fetchAll();
        require_once BASE_PATH . '/template/admin/questions/edit.php';
    }

    public function update($request, $id)
    {
        $db = new Database();

        $request = filterHtmlSpecialChars($request);

        // For images
        $allowedType = ['image/png', 'image/jpg', 'image/jpeg', 'image/gif' , ''];

        if(empty($request['title']) || empty($request['body'] || empty($request['tags']))) {
            flash('edit_question_error', 'لطفا همه فیلد ها را پر کنید');
            redirectBack();

        } elseif(!in_array($request['image']['type'], $allowedType)) {
            flash('edit_question_error', 'لطفا عکس وارد کنید');
            redirectBack();

        } else {
            $tags = isset($request['tags']) ? $request['tags'] : [];
            unset($request['tags']);
            $question = $db->select("SELECT * FROM `questions` WHERE id = ?;", [$id])->fetch();
    
            // Uploading image
            $imageService = new ImageService();
            if(isset($request['image']) && $request['image']['name'] !== "") {
    
                if($question['image']) {
                    $imageService->removeImage($question['image']);
                }
    
                $resault = $imageService->saveImage($request['image'], 'images');
    
                if($resault) {
                    $request['image'] = $resault;
                } else {
                    unset($request['image']);
                }
    
            } else {
                unset($request['image']);
            }
            
            // Update question
            $db->update('questions', $id, array_keys($request), $request);
    
            $question_tags = $db->select("SELECT `id` FROM `question_tag` WHERE `question_id` = ?;", [$id])->fetchAll();
    
            // Delete old tags
            foreach($question_tags as $single_tag) {
                $db->delete('question_tag', $single_tag['id']);
            }
    
            // Create new tags
            foreach($tags as $tagId) {
                $db->insert('question_tag', ['question_id', 'tag_id'], [$question['id'], $tagId]);
            }
    
            redirect('admin/question');
        }

    }

    public function delete($id)
    {
        $db = new Database();
        $question = $db->select("SELECT * FROM `questions` WHERE id = ?;", [$id])->fetch();

        // Deleting image
        if($question['image']) {
            $imageService = new ImageService();
            $imageService->removeImage($question['image']);
        }

        $db->delete('questions', $id);
        redirect('admin/question');
    }
}