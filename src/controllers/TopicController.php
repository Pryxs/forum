<?php

namespace App\controllers;

use App\models\Toast;
use App\models\entities\Vote;
use App\models\entities\Comment;
use App\models\entities\Topic;
use App\models\helpers\TopicHelper;

class TopicController
{
    public function index()
    {

    }


    public function store()
    {
        global $app;

        $topic = new Topic($app->request->getData());
        $errors = $topic->isValide();

        if(count($errors) === 0){
            $topic->create();
            Toast::setToast($topic->title . ' créé avec succès', '-success');
            header('location:/');
        } else {
            $params = TopicHelper::getTopicsData();

            $errors = [
                'errors' =>  $errors,   
                'fields' => [
                    'title' => $topic->title,
                    'description' => $topic->description
                ]
            ];

            return $app->router->renderView('home', 'baseLayout', array_merge($params, $errors));
        };
    }


    public function update()
    {
        global $app;

        $topic = new Topic($app->request->getData());
        $errors = $topic->isValide();

        if(count($errors) === 0){
            $topic->update();
            Toast::setToast('Modifier avec succès', '-success');
            header('location:/');
        } else {
            $params = TopicHelper::getTopicsData();

            $errors = [
                'errors' =>  $errors
            ];

            return $app->router->renderView('home', 'baseLayout', array_merge($params, $errors));
        };
    }


    public function destroy()
    {
        global $app;
        $queryParams = $app->request->getData();

        if(array_key_exists('id', $queryParams)){
            $deletedTopic = Topic::get($queryParams['id']);
            Topic::delete($queryParams['id']);
            Toast::setToast($deletedTopic['title'] . ' a été supprimé', '-success');
            header('location:/');
        }

        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }


    public function show()
    {            
        global $app;
        $queryParams = $app->request->getData();

        if(array_key_exists('id', $queryParams) && !empty($queryParams['id'])){
            $topic = Topic::get($queryParams['id']);
            $latestTopics = Topic::getAll($queryParams['id']);


            if(!$topic){
                Toast::setToast('Topic introuvable', '-alert');
                header('Location:/');
            }

            $comments = Comment::getAllByTopic($topic['id']);
            
            $params = [
                'topic' => $topic,
                'latestTopics' => $latestTopics,
                'comments' => $comments
            ];

            return $app->router->renderView('topic', 'baseLayout', $params);
        }

        header('Location:/');
    }


    public function edit()
    {            
        global $app;
        $queryParams = $app->request->getData();

        if(array_key_exists('id', $queryParams) && !empty($queryParams['id'])){
            $topic = Topic::get($queryParams['id']);
                
            if(!$topic){
                Toast::setToast('Topic introuvable', '-alert');
                header('Location:/');
            }

            $params = [
                'topic' => $topic
            ];

            return $app->router->renderView('topic-edit', 'baseLayout', $params);
        }

        header('Location:/');
    }
}