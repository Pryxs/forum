<?php

use App\core\Application;
use App\controllers\AuthController;
use App\controllers\HomeController;
use App\controllers\CommentController;
use App\controllers\VoteController;
use App\controllers\TopicController;
use App\config\Config;

require '../vendor/autoload.php';

// session_start();

$app = new Application(getcwd(), new Config());


/*
    /subject/action?id=...

    GET /subject => index (page principale)
    GET /subject/create => create (page création)
    GET /subject/view?id=... => show (page de l'élément)
    GET /subject/edit?id=... => edit (page d'édition de l'élément)

    POST /subject/destroy  => delete (action de suppression de l'élément)
    POST /subject => store (action d'insertion de l'élément)
    POST /subject/update => update (action d'edition de l'élément)
*/

$app->router->get('/', [new HomeController(), 'index'], 'baseLayout');

//TOPICS

$app->router->get('/topic/view', [new TopicController(), 'show'], 'baseLayout');
$app->router->get('/topic/edit', [new TopicController(), 'edit'], 'baseLayout');
$app->router->post('/topic', [new TopicController(), 'store']);
$app->router->post('/topic/destroy', [new TopicController(), 'destroy']);
$app->router->post('/topic/update', [new TopicController(), 'update']);


//COMMENTS

$app->router->post('/comment', [new CommentController(), 'store']);


// VOTE    

$app->router->post('/vote', [new VoteController(), 'index']);


//AUTH

$app->router->get('/login', 'login');
$app->router->post('/login', [new AuthController(), 'login']);

$app->router->get('/register', 'register');
$app->router->post('/register', [new AuthController(), 'register']);

$app->router->get('/logout', [new AuthController(), 'logout']);



$app->run();