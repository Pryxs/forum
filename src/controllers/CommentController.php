<?php
namespace App\controllers;

use App\core\Session;
use App\models\entities\Comment;

class CommentController
{
    public function store()
    {
        global $app;

        
        $session = new Session();
        $auth = $session->get();

        $user_id  = $auth['id'];
        $data = $app->request->getData();

        $comment = new Comment($data['text'], $data['topic_id'], $user_id);

        $errors = $comment->isValide();

        if(count($errors) === 0) $comment->create();

        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
}