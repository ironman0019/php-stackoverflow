<?php

namespace Activities\Admin;

use Database\Database;

class Tag extends Admin {

    public function index()
    {
        $db = new Database();
        $tags = $db->select("SELECT * FROM `tags`;")->fetchAll();
        require_once BASE_PATH . '/template/admin/tag/index.php';
    }

    public function create()
    {
        $db = new Database();
        require_once BASE_PATH . '/template/admin/tag/create.php';
    }

    public function store($request)
    {
        $request = filterHtmlSpecialChars($request);
        
        if(empty($request['name'])) {
            flash('create_tag_error', 'لطفا همه فیلد ها را پر کنید');
            redirect('admin/tag/create');

        } else {
            $db = new Database();
            $db->insert('tags', array_keys($request), $request);
            redirect('admin/tag');
        }

    }

    public function edit($id)
    {
        $db = new Database();
        $tag = $db->select("SELECT * FROM `tags` WHERE id = ?;", [$id])->fetch();
        require_once BASE_PATH . '/template/admin/tag/edit.php';
    }

    public function update($request, $id)
    {
        $request = filterHtmlSpecialChars($request);

        if(empty($request['name'])) {
            flash('edit_tag_error', 'لطفا همه فیلد ها را پر کنید');
            redirect("admin/tag/edit/$id");

        } else {
            $db = new Database();
            $db->update('tags', $id, array_keys($request), $request);
            redirect('admin/tag');
        }

    }

    public function delete($id)
    {
        $db = new Database();
        $db->delete('tags', $id);
        redirect('admin/tag');
    }
}