<?php

namespace Activities\Admin;

use Activities\Services\ImageService;
use Database\Database;

class QuestionImage extends Admin {

    public function index($id)
    {
        $db = new Database();
        $question = $db->select("SELECT * FROM `questions` WHERE id = ?;", [$id])->fetch();
        $images = $db->select("SELECT * FROM `question_images` WHERE `question_id` = ?;", [$id])->fetchAll();
        require_once BASE_PATH . '/template/admin/question-images/index.php';
    }

    public function create($id)
    {
        $db = new Database();
        $question = $db->select("SELECT * FROM `questions` WHERE id = ?;", [$id])->fetch();
        require_once BASE_PATH . '/template/admin/question-images/create.php';
    }

    public function store($request, $id)
    {
        $db = new Database();

        // For images
        $allowedType = ['image/png', 'image/jpg', 'image/jpeg', 'image/gif'];

        if(!in_array($request['image']['type'], $allowedType)) {
            flash('create_question_image_error', 'لطفا عکس وارد کنید');
            redirectBack();

        } else {
            // Image
            $imageService = new ImageService();
            $resault = $imageService->saveImage($request['image'], 'question-images');

            if ($resault) {
                $request['image'] = $resault;
            } else {
                unset($request['image']);
            }

            $request['question_id'] = $id;

            // store question-image
            $db->insert('question_images', array_keys($request), $request);

            redirect('admin/question/' . $id . '/images');
        }

    }

    public function edit($id, $image_id)
    {
        $db = new Database();
        $question = $db->select("SELECT * FROM `questions` WHERE id = ?;", [$id])->fetch();
        $image = $db->select("SELECT * FROM `question_images` WHERE id = ?;", [$image_id])->fetch();
        require_once BASE_PATH . '/template/admin/question-images/edit.php';
    }

    public function update($request, $id, $image_id)
    {
        $db = new Database();

        $image = $db->select("SELECT * FROM `question_images` WHERE id = ?;", [$image_id])->fetch();

        // For images
        $allowedType = ['image/png', 'image/jpg', 'image/jpeg', 'image/gif', ''];

        if(!in_array($request['image']['type'], $allowedType)) {
            flash('edit_question_image_error', 'لطفا عکس وارد کنید');
            redirectBack();

        } else {
            // Uploading image
            $imageService = new ImageService();
            if (isset($request['image']) && $request['image']['name'] !== "") {

                if ($image['image']) {
                    $imageService->removeImage($image['image']);
                }

                $resault = $imageService->saveImage($request['image'], 'question-images');

                if ($resault) {
                    $request['image'] = $resault;
                } else {
                    unset($request['image']);
                }
            } else {
                unset($request['image']);
            }

            // question id
            $request['question_id'] = $id;

            // Update question_images
            $db->update('question_images', $image_id, array_keys($request), $request);


            redirect('admin/question/' . $id . '/images');
        }

    }

    public function delete($id, $image_id)
    {
        $db = new Database();
        $image = $db->select("SELECT * FROM `question_images` WHERE id = ?;", [$image_id])->fetch();

        // Deleting image
        if($image['image']) {
            $imageService = new ImageService();
            $imageService->removeImage($image['image']);
        }

        $db->delete('question_images', $image_id);
        redirect('admin/question/' . $id . '/images');
    }
}