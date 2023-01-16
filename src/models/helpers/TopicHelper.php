<?php

namespace App\models\helpers;

use App\models\entities\Topic;
use App\models\entities\Vote;
use App\core\Session;  


class TopicHelper
{
    public static function getTopicsData()
    {
        global $app;

        $session = new Session();
        $auth = $session->get();

        $currentUserId = $auth['id'];

        $votedTopicsId = Vote::getAllVotedTopic();
        $topics = self::getAllWithVote($votedTopicsId);
        $famous = Topic::getFamous();
        $userTopics = Topic::getAllByUser($currentUserId);

        if(in_array($famous['id'], $votedTopicsId)) $famous['voted'] = true;

        $params = [
            'famous' => $famous,
            'topics' => $topics,
            'userTopics' => $userTopics
        ];

        return $params;
    }


    // récupère les topics avec la clef voted => true sur les topics mappé sur l'id par la liste en paramètre
    public static function getAllWithVote(array $votedTopicByUser)
    {
        $topics = Topic::getAll();

        $topics = array_map(
            function($n) use ($votedTopicByUser){
                if (in_array($n['id'], $votedTopicByUser)) {
                    $n['voted'] = true;
                }
                return $n;
            }, 
            $topics
        );

        return $topics;
    }
}