<?php

namespace App\models\entities;

use App\core\Session;  

class Vote
{
    private int $user_id;
    private int $topic_id;

    public function __construct($user_id, $topic_id){
        $this->user_id = $user_id;
        $this->topic_id = $topic_id;
    }


    public function exist()
    {
        global $app;
        
        $query = "SELECT 1 FROM Vote WHERE user_id = :user_id AND topic_id = :topic_id";
        $args = [
            ":user_id" => $this->user_id,
            ":topic_id" => $this->topic_id
        ];

        $statement = $app->database->exec($query, $args);
        $response = $statement->fetch();

        return $response;
    }


    // TODO : catch error 
    public function create()
    {
        global $app;
        
        $query = "INSERT INTO Vote (user_id, topic_id) VALUES (:user_id, :topic_id)";
        $args = [
            ':user_id' => $this->user_id,
            ':topic_id' => $this->topic_id,
        ];

        $response = $app->database->exec($query, $args);

        return true;
    }


    public function delete()
    {
        global $app;
        
        $query = "DELETE FROM Vote
            WHERE Vote.user_id = :user_id
            AND Vote.topic_id = :topic_id";

        $args = [
            ':user_id' => $this->user_id,
            ':topic_id' => $this->topic_id,
        ];

        $response = $app->database->exec($query, $args);

        return true;
    }


    // récupère les Topic deja voté par l'utilisateur current
    public static function getAllVotedTopic()
    {
        global $app;

        $session = new Session();
        $auth = $session->get();

        $user_id = $auth['id'];

        $query = "SELECT v.topic_id
        FROM Vote AS v
        WHERE v.user_id = :user_id";

    $args = [
        ':user_id' => $user_id
    ];

    $statement = $app->database->exec($query, $args);
    $response = $statement->fetchAll(\PDO::FETCH_COLUMN);

    return $response;
    }

}