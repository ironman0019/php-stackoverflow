<?php

namespace Activities\Admin;

use Database\Database;

class User extends Admin {

    public function index()
    {
        $db = new Database();
        $users = $db->select("SELECT * FROM `users`;")->fetchAll();
        require_once BASE_PATH . '/template/admin/users/index.php';
    }


    public function edit($id)
    {
        $db = new Database();
        $user = $db->select("SELECT * FROM `users` WHERE id = ?;", [$id])->fetch();
        require_once BASE_PATH . '/template/admin/users/edit.php';
    }

    public function update($request, $id)
    {
        $request = filterHtmlSpecialChars($request);

        if(empty($request['username'])) {
            flash('edit_user_error', 'لطفا همه فیلد ها را پر کنید');
            redirect("admin/users/edit/$id");

        } else {
            $db = new Database();
            $db->update('users', $id, ['username', 'type'], [$request['username'], $request['type']]);
            redirect('admin/users');
        }
    }

    public function setType($id)
    {
        $db = new Database();
        $user = $db->select("SELECT * FROM `users` WHERE id = ?;", [$id])->fetch();

        if($user['type'] == 0) {
            $db->update('users', $id, ['type'], [1]);
        } else {
            $db->update('users', $id, ['type'], [0]);
        }

        redirect('admin/users');
    }

    public function delete($id)
    {
        $db = new Database();
        $db->delete('users', $id);
        redirect('admin/users');
    }
}