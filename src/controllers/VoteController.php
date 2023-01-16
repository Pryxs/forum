<?php
namespace App\controllers;

use App\core\Session;
use App\models\entities\Vote;

class VoteController
{
    public function index()
    {
        global $app;

        
        $session = new Session();
        $auth = $session->get();

        $user_id  = $auth['id'];
        $topic_id = $app->request->getData()['topic_id'];

        $vote = new Vote($user_id, $topic_id);
        $exist = $vote->exist();

        if(!$exist){
            $vote->create();
        } else {
            $vote->delete();
        }

        header('location:/');
    }
}