<?php

namespace Activities\App ;

use Database\Database;
use Activities\Services\ImageService;

class Home {

    public function index()
    {
        $db = new Database();

        // $questions = $db->select("
        // select q.id,
        // q.title,
        // q.body,
        // q.view,
        // q.created_at,
        // (select COUNT(*) FROM answers where question_id = q.id) AS answer_count,
        // (select COUNT(*) FROM votes where question_id = q.id) AS vote_count,
        // (select GROUP_CONCAT(name SEPARATOR ', ') FROM tags where id IN (SELECT tag_id FROM question_tag WHERE question_id = q.id)) AS tags,
        // (select username FROM users where id = q.user_id) AS username FROM questions q Order BY q.created_at DESC LIMIT 10;
        // ")->fetchAll();

        $questions = $db->select(
        "SELECT 
        `questions`.*,
        `users`.`username` AS `username`,
        GROUP_CONCAT(DISTINCT `answers`.`id` ORDER BY `answers`.`id` SEPARATOR ', ') AS `answers`,
        GROUP_CONCAT(`votes`.`type` ORDER BY `votes`.`type` SEPARATOR ', ') AS `votes`,
        GROUP_CONCAT(DISTINCT `tags`.`name` ORDER BY `tags`.`name` SEPARATOR ', ') AS `tags`,
        GROUP_CONCAT(DISTINCT `tags`.`id` ORDER BY `tags`.`id` SEPARATOR ',') AS `tagIds`
        FROM 
        `questions`
        INNER JOIN 
        `users` ON `questions`.`user_id` = `users`.`id`
        LEFT JOIN 
        `answers` ON `answers`.`question_id` = `questions`.`id`
        LEFT JOIN 
        `votes` ON `votes`.`question_id` = `questions`.`id`
        LEFT JOIN 
        `question_tag` ON `questions`.`id` = `question_tag`.`question_id`
        LEFT JOIN 
        `tags` ON `question_tag`.`tag_id` = `tags`.`id`
        GROUP BY 
        `questions`.`id`
        ORDER BY `questions`.`created_at` DESC LIMIT 10;
        ")->fetchAll();

        $tags = $db->select('select * from tags')->fetchAll();

        $popularTags = $db->select(
        "   SELECT `name`, `tags`.`id`, COUNT(`question_tag`.`tag_id`) AS `useage_count` 
            FROM `tags` 
            JOIN `question_tag` ON `tags`.`id` = `question_tag`.`tag_id`
            GROUP BY `tags`.`id` 
            ORDER BY `useage_count` DESC LIMIT 10;
        ")->fetchAll();

        $mostViewedQuestions = $db->select("SELECT `id`, `title` FROM `questions` ORDER BY `view` DESC LIMIT 5;");


        $activeUsers = $db->select("SELECT `username`, `id` FROM `users` ORDER BY (SELECT COUNT(*) FROM `questions` WHERE `questions`.`user_id` = `users`.`id`) DESC LIMIT 5;")->fetchAll();



        require_once BASE_PATH . '/template/app/index.php';
    } 


    public function question($id)
    {
        $db = new Database();

        $question = $db->select(
            "SELECT 
            `questions`.*,
            `users`.`username` AS `username`,
            GROUP_CONCAT(DISTINCT `answers`.`id` ORDER BY `answers`.`id` SEPARATOR ', ') AS `answers`,
            GROUP_CONCAT(`votes`.`type` ORDER BY `votes`.`type` SEPARATOR ', ') AS `votes`,
            GROUP_CONCAT(DISTINCT `tags`.`name` ORDER BY `tags`.`name` SEPARATOR ', ') AS `tags`,
            GROUP_CONCAT(DISTINCT `tags`.`id` ORDER BY `tags`.`id` SEPARATOR ',') AS `tagIds`
            FROM 
            `questions`
            INNER JOIN 
            `users` ON `questions`.`user_id` = `users`.`id`
            LEFT JOIN 
            `answers` ON `answers`.`question_id` = `questions`.`id`
            LEFT JOIN 
            `votes` ON `votes`.`question_id` = `questions`.`id`
            LEFT JOIN 
            `question_tag` ON `questions`.`id` = `question_tag`.`question_id`
            LEFT JOIN 
            `tags` ON `question_tag`.`tag_id` = `tags`.`id`
            WHERE `questions`.`id` = ?
            GROUP BY 
            `questions`.`id`;
            ",
            [$id]
        )->fetch();

        if ($question) {

            $answers = $db->select(
                "SELECT `answers`.*, 
                (SELECT `username` FROM `users` WHERE `id` = `answers`.`user_id`) AS `username`,
                COUNT(CASE WHEN `votes`.`type` = 0 THEN 1 END) AS `up_votes`,
                COUNT(CASE WHEN `votes`.`type` = 1 THEN 1 END) AS `down_votes`
                FROM `answers` LEFT JOIN `votes` ON `votes`.`answer_id` = `answers`.`id`
                WHERE `answers`.`question_id` = ?
                GROUP BY `answers`.`id` ORDER BY `answers`.`is_accepted` DESC, `answers`.`created_at` DESC; 
            ",
                [$id]
            )->fetchAll();

            $popularTags = $db->select(
                "SELECT `name`, `tags`.`id`, COUNT(`question_tag`.`tag_id`) AS `useage_count` 
                FROM `tags` 
                JOIN `question_tag` ON `tags`.`id` = `question_tag`.`tag_id`
                GROUP BY `tags`.`id` 
                ORDER BY `useage_count` DESC LIMIT 10;
            ")->fetchAll();

            $mostViewedQuestions = $db->select("SELECT `id`, `title` FROM `questions` ORDER BY `view` DESC LIMIT 5;");


            $activeUsers = $db->select("SELECT `username`, `id` FROM `users` ORDER BY (SELECT COUNT(*) FROM `questions` WHERE `questions`.`user_id` = `users`.`id`) DESC LIMIT 5;")->fetchAll();


            $answer_comments = $db->select(
                "SELECT 
                `comments`.`id`, 
                `comments`.`answer_id`,
                `comments`.`body`,
                `comments`.`status`, 
                `comments`.`created_at`, 
                `users`.`username`
                FROM 
                `comments`
                INNER JOIN 
                `users` ON `comments`.`user_id` = `users`.`id`
                INNER JOIN 
                `answers` ON `comments`.`answer_id` = `answers`.`id`
                WHERE 
                `answers`.`question_id` = ?
                AND
                `comments`.`status` = 1;
            ",
            [$id]
            )->fetchAll();

            $question_comments = $db->select("SELECT `comments`.*, `users`.`username` AS `username` FROM `comments` INNER JOIN `users` ON `comments`.`user_id` = `users`.`id` WHERE `comments`.`question_id` = ? AND `comments`.`status` = 1;", [$id])->fetchAll();

            $question_images = $db->select("SELECT * FROM `question_images` WHERE `question_id` = ?;", [$id])->fetchAll();



            require_once BASE_PATH . '/template/app/question.php';

            // Add view in questions table
            $view = $question['view'] + 1;
            $db->update('questions', $id, ['view'], [$view]);
        } else {
            redirect('/');
        }

    }


    public function tag($id)
    {

        $db = new Database();

        $tag = $db->select("SELECT `tags`.`name` FROM `tags` WHERE `id` = ?;", [$id])->fetch();

        if($tag) {
            $questions = $db->select(
                "SELECT 
                `questions`.*,
                `users`.`username` AS `username`,
                GROUP_CONCAT(DISTINCT `answers`.`id` ORDER BY `answers`.`id` SEPARATOR ', ') AS `answers`,
                GROUP_CONCAT(`votes`.`type` ORDER BY `votes`.`type` SEPARATOR ', ') AS `votes`
                FROM 
                `questions`
                INNER JOIN 
                `users` ON `questions`.`user_id` = `users`.`id`
                LEFT JOIN 
                `answers` ON `answers`.`question_id` = `questions`.`id`
                LEFT JOIN 
                `votes` ON `votes`.`question_id` = `questions`.`id`
                LEFT JOIN 
                `question_tag` ON `questions`.`id` = `question_tag`.`question_id`
                WHERE `question_tag`.`tag_id` = ?
                GROUP BY 
                `questions`.`id`
                ORDER BY `questions`.`created_at` DESC LIMIT 10;
                ", [$id]
            )->fetchAll();

            $popularTags = $db->select(
                "SELECT `name`, `tags`.`id`, COUNT(`question_tag`.`tag_id`) AS `useage_count` 
                FROM `tags` 
                JOIN `question_tag` ON `tags`.`id` = `question_tag`.`tag_id`
                GROUP BY `tags`.`id` 
                ORDER BY `useage_count` DESC LIMIT 10;
            ")->fetchAll();

            $mostViewedQuestions = $db->select("SELECT `id`, `title` FROM `questions` ORDER BY `view` DESC LIMIT 5;");


            $activeUsers = $db->select("SELECT `username`, `id` FROM `users` ORDER BY (SELECT COUNT(*) FROM `questions` WHERE `questions`.`user_id` = `users`.`id`) DESC LIMIT 5;")->fetchAll();

            require_once BASE_PATH . '/template/app/tag.php';

        } else {
            redirect('/');
        }

    }


    public function tags()
    {
        $db = new Database();

        $tags = $db->select("SELECT * FROM `tags`;")->fetchAll();

        $popularTags = $db->select(
            "SELECT `name`, `tags`.`id`, COUNT(`question_tag`.`tag_id`) AS `useage_count` 
            FROM `tags` 
            JOIN `question_tag` ON `tags`.`id` = `question_tag`.`tag_id`
            GROUP BY `tags`.`id` 
            ORDER BY `useage_count` DESC LIMIT 10;
        ")->fetchAll();

        $mostViewedQuestions = $db->select("SELECT `id`, `title` FROM `questions` ORDER BY `view` DESC LIMIT 5;");


        $activeUsers = $db->select("SELECT `username`, `id` FROM `users` ORDER BY (SELECT COUNT(*) FROM `questions` WHERE `questions`.`user_id` = `users`.`id`) DESC LIMIT 5;")->fetchAll();

        require_once BASE_PATH . '/template/app/all-tags.php';

    }


    public function storeQuestion($request)
    {
        if (isset($_SESSION['user']) && $_SESSION['user'] != "") {

            $db = new Database();
            $request = filterHtmlSpecialChars($request);

            // For images
            $allowedType = ['image/png', 'image/jpg', 'image/jpeg', 'image/gif', ''];

            if(empty($request['title']) || empty($request['body'] || empty($request['tags']))) {
                flash('alert', 'لطفا همه فیلد ها را پر کنید');
                redirectBack();
    
    
            } elseif(!in_array($request['image']['type'], $allowedType)) {
                flash('alert', 'لطفا عکس وارد کنید');
                redirectBack();

            } else {
                //tags
                $tags = $request['tags'];
                unset($request['tags']);
                //image
                $imageService = new ImageService();
                $result =  $imageService->saveImage($request['image'], 'images');
                if ($result) {
                    $request['image'] = $result;
                } else {
                    unset($request['image']);
                }

                $request['user_id'] = $_SESSION['user'];

                //insert question
                $quesitonId = $db->insert('questions', array_keys($request), $request);

                foreach ($tags as $tag_id) {
                    $db->insert('question_tag', ['question_id', 'tag_id'], [$quesitonId, $tag_id]);
                }
                flash('success', 'سوال ایجاد شد');
                redirectBack();
            }

        } else {
            flash('alert', 'ابتدا وارد شوید');
            redirectBack();
        }
    }


    public function answerVote($request)
    {
        $db = new Database();
        $value = explode(',', $request);
        $value = array_map('intval', $value);



        if(isset($_SESSION['user']) && $_SESSION['user'] != "") {
            $oldVote = $db->select("SELECT * FROM `votes` WHERE `answer_id` = ? AND `user_id` = ?;", [$value[0], $_SESSION['user']])->fetch();


            if($oldVote) {
                if($oldVote['type'] == $value[1]) {
                    $db->delete('votes', $oldVote['id']);

                } else {
                    $db->delete('votes', $oldVote['id']);
                    $db->insert('votes', ['answer_id', 'type', 'user_id'], [$value[0], $value[1], $_SESSION['user']]);
                }

            } else {
                $db->insert('votes', ['answer_id', 'type', 'user_id'], [$value[0], $value[1], $_SESSION['user']]);
            }

            echo json_encode(['status' => 'success', 'message' => 'Vote registered successfully']);

        } else {
            echo json_encode(['status' => 'error', 'message' => 'You need to log in to vote']);
        }
    }

    public function questionVote($request)
    {
        $db = new Database();
        $value = explode(',', $request);
        $value = array_map('intval', $value);



        if(isset($_SESSION['user']) && $_SESSION['user'] != "") {
            $oldVote = $db->select("SELECT * FROM `votes` WHERE `question_id` = ? AND `user_id` = ?;", [$value[0], $_SESSION['user']])->fetch();


            if($oldVote) {
                if($oldVote['type'] == $value[1]) {
                    $db->delete('votes', $oldVote['id']);

                } else {
                    $db->delete('votes', $oldVote['id']);
                    $db->insert('votes', ['question_id', 'type', 'user_id'], [$value[0], $value[1], $_SESSION['user']]);
                }

            } else {
                $db->insert('votes', ['question_id', 'type', 'user_id'], [$value[0], $value[1], $_SESSION['user']]);
            }

            echo json_encode(['status' => 'success', 'message' => 'Vote registered successfully']);

        } else {
            echo json_encode(['status' => 'error', 'message' => 'You need to log in to vote']);
        } 
    }


    public function acceptAnswer($id)
    {
        $db = new Database();

        $answer = $db->select("SELECT * FROM `answers` WHERE `id` = ?;", [$id])->fetch();
        $question = $db->select("SELECT * FROM `questions` WHERE `id` = ?;", [$answer['question_id']])->fetch();

        if(isset($_SESSION['user'])) {
            if($answer) {
                if($question['user_id'] == $_SESSION['user']) {
                    if($answer['is_accepted'] !== 1) {
                        $db->update('answers', $id, ['is_accepted'], [1]);

                        // Find old answer & set the is_accepted to 0
                        $answer = $db->select("SELECT * FROM `answers` WHERE `answers`.`question_id` = ? AND `answers`.`is_accepted` = 1 AND `answers`.`updated_at` != NOW();", [$question['id']])->fetch();
                        $db->update('answers', $answer['id'], ['is_accepted'], [0]);

                        redirectBack();
                    }
                } else {
                    redirectBack();
                }

            } else {
                redirectBack();
            }
        } else {
            redirectBack();
        }
    }

    public function answerComment($request, $id)
    {
        $db = new Database();
        $request = filterHtmlSpecialChars($request);

        if(isset($_SESSION['user'])) {
            if(empty($request['body'])) {
                flash('alert', 'لطفا فیلد را پر کنید');
                redirectBack();
            }
            $db->insert('comments', ['user_id', 'answer_id', 'body'], [$_SESSION['user'], $id, $request['body']]);
            flash('success', 'کامنت ایجاد شد . پس از تایید نمایش داده میشود');
            redirectBack();

        } else {
            redirect('login');
        }
    }


    public function questionComment($request, $id)
    {
        $db = new Database();
        $request = filterHtmlSpecialChars($request);

        if(isset($_SESSION['user'])) {
            if(empty($request['body'])) {
                flash('alert', 'لطفا فیلد را پر کنید');
                redirectBack();
            }
            $db->insert('comments', ['user_id', 'question_id', 'body'], [$_SESSION['user'], $id, $request['body']]);
            flash('success', 'کامنت ایجاد شد . پس از تایید نمایش داده میشود');
            redirectBack();

        } else {
            redirect('login');
        }
    }


    public function userPanel()
    {

        if (isset($_SESSION['user'])) {
            $db = new Database();

            $questions = $db->select(
                "SELECT 
                `questions`.*,
                `users`.`username` AS `username`,
                GROUP_CONCAT(DISTINCT `answers`.`id` ORDER BY `answers`.`id` SEPARATOR ', ') AS `answers`,
                GROUP_CONCAT(`votes`.`type` ORDER BY `votes`.`type` SEPARATOR ', ') AS `votes`,
                GROUP_CONCAT(DISTINCT `tags`.`name` ORDER BY `tags`.`name` SEPARATOR ', ') AS `tags`,
                GROUP_CONCAT(DISTINCT `tags`.`id` ORDER BY `tags`.`id` SEPARATOR ',') AS `tagIds`
                FROM 
                `questions`
                INNER JOIN 
                `users` ON `questions`.`user_id` = `users`.`id`
                LEFT JOIN 
                `answers` ON `answers`.`question_id` = `questions`.`id`
                LEFT JOIN 
                `votes` ON `votes`.`question_id` = `questions`.`id`
                LEFT JOIN 
                `question_tag` ON `questions`.`id` = `question_tag`.`question_id`
                LEFT JOIN 
                `tags` ON `question_tag`.`tag_id` = `tags`.`id`
                WHERE `questions`.`user_id` = ? 
                GROUP BY 
                `questions`.`id`
                ORDER BY `questions`.`created_at` DESC;
                ",
                [$_SESSION['user']]
            )->fetchAll();


            $popularTags = $db->select(
                "SELECT `name`, `tags`.`id`, COUNT(`question_tag`.`tag_id`) AS `useage_count` 
                FROM `tags` 
                JOIN `question_tag` ON `tags`.`id` = `question_tag`.`tag_id`
                GROUP BY `tags`.`id` 
                ORDER BY `useage_count` DESC LIMIT 10;
            
            ")->fetchAll();

            $mostViewedQuestions = $db->select("SELECT `id`, `title` FROM `questions` ORDER BY `view` DESC LIMIT 5;");


            $activeUsers = $db->select("SELECT `username`, `id` FROM `users` ORDER BY (SELECT COUNT(*) FROM `questions` WHERE `questions`.`user_id` = `users`.`id`) DESC LIMIT 5;")->fetchAll();



            require_once BASE_PATH . '/template/app/user_panel.php';

        } else {
            redirect('login');
        }
        
    }

    public function questionEdit($id)
    {
        if(isset($_SESSION['user'])) {
            $db = new Database();

            $question = $db->select("SELECT * FROM `questions` WHERE `id` = ?;", [$id])->fetch();

            if($question) {
                $tags = $db->select('select * from tags')->fetchAll();
                $question_tags = $db->select("SELECT `tag_id` FROM `question_tag` WHERE `question_id` = ?;", [$id])->fetchAll();
                require_once BASE_PATH . '/template/app/question_edit.php';

            } else {
                redirect('/');
            }


        } else {
            redirect('login');
        }
    }

    public function questionUpdate($request, $id)
    {
        if(isset($_SESSION['user'])) {
            $db = new Database();
            $request = filterHtmlSpecialChars($request);

            // For images
            $allowedType = ['image/png', 'image/jpg', 'image/jpeg', 'image/gif', ''];

            if (empty($request['title']) || empty($request['body'] || empty($request['tags']))) {
                flash('alert', 'لطفا همه فیلد ها را پر کنید');
                redirectBack();
            } elseif (!in_array($request['image']['type'], $allowedType)) {
                flash('alert', 'لطفا عکس وارد کنید');
                redirectBack();
            } else {
                $tags = isset($request['tags']) ? $request['tags'] : [];
                unset($request['tags']);
                $question = $db->select("SELECT * FROM `questions` WHERE id = ?;", [$id])->fetch();

                // Uploading image
                $imageService = new ImageService();
                if (isset($request['image']) && $request['image']['name'] !== "") {

                    if ($question['image']) {
                        $imageService->removeImage($question['image']);
                    }

                    $resault = $imageService->saveImage($request['image'], 'images');

                    if ($resault) {
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
                foreach ($question_tags as $single_tag) {
                    $db->delete('question_tag', $single_tag['id']);
                }

                // Create new tags
                foreach ($tags as $tagId) {
                    $db->insert('question_tag', ['question_id', 'tag_id'], [$question['id'], $tagId]);
                }

                redirect('user/panel');
            }
        } else {
            redirect('login');
        }
    }


    public function indexSearch($request)
    {
        $db = new Database();

        $request = $request['search'];


        $questions = $db->select(
            "SELECT 
            `questions`.*,
            `users`.`username` AS `username`,
            GROUP_CONCAT(DISTINCT `answers`.`id` ORDER BY `answers`.`id` SEPARATOR ', ') AS `answers`,
            GROUP_CONCAT(`votes`.`type` ORDER BY `votes`.`type` SEPARATOR ', ') AS `votes`,
            GROUP_CONCAT(DISTINCT `tags`.`name` ORDER BY `tags`.`name` SEPARATOR ', ') AS `tags`,
            GROUP_CONCAT(DISTINCT `tags`.`id` ORDER BY `tags`.`id` SEPARATOR ',') AS `tagIds`
            FROM 
            `questions`
            INNER JOIN 
            `users` ON `questions`.`user_id` = `users`.`id`
            LEFT JOIN 
            `answers` ON `answers`.`question_id` = `questions`.`id`
            LEFT JOIN 
            `votes` ON `votes`.`question_id` = `questions`.`id`
            LEFT JOIN 
            `question_tag` ON `questions`.`id` = `question_tag`.`question_id`
            LEFT JOIN 
            `tags` ON `question_tag`.`tag_id` = `tags`.`id`
            WHERE `questions`.`title` LIKE '%$request%' OR `questions`.`body` LIKE '%$request%'
            GROUP BY 
            `questions`.`id`
            ORDER BY `questions`.`created_at` DESC LIMIT 10;
            ")->fetchAll();


        $popularTags = $db->select(
        "SELECT `name`, `tags`.`id`, COUNT(`question_tag`.`tag_id`) AS `useage_count` 
            FROM `tags` 
            JOIN `question_tag` ON `tags`.`id` = `question_tag`.`tag_id`
            GROUP BY `tags`.`id` 
            ORDER BY `useage_count` DESC LIMIT 10;
        ")->fetchAll();

        $mostViewedQuestions = $db->select("SELECT `id`, `title` FROM `questions` ORDER BY `view` DESC LIMIT 5;");


        $activeUsers = $db->select("SELECT `username`, `id` FROM `users` ORDER BY (SELECT COUNT(*) FROM `questions` WHERE `questions`.`user_id` = `users`.`id`) DESC LIMIT 5;")->fetchAll();



        require_once BASE_PATH . '/template/app/index_search.php';
    }
}