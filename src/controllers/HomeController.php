<?php
namespace App\controllers;

use App\models\Toast;
use App\models\entities\Topic;
use App\models\helpers\TopicHelper;
use App\models\entities\Vote;

class HomeController
{
    public function index()
    {
        global $app;

        $params = TopicHelper::getTopicsData();

        return $app->router->renderView('home', 'baseLayout', $params);
    }
}