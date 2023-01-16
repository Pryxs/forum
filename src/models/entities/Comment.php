<?php

namespace App\models\entities;

use App\core\Session;  

class Comment extends BaseModel
{
    public const RULES = [
        'text' => [
            'required' => true,
            'min' => 1,
            'max' => 200,
        ]
    ];

    public string $topic_id;
    public string $user_id;
    public string $text;
    public array $errors = [];

    public function __construct($text, $topic_id, $user_id){
        $this->text = $text ?? '';
        $this->topic_id = $topic_id ?? '';
        $this->user_id = $user_id ?? '';
        parent::__construct(self::RULES);
    }


    public function create()
    {
        global $app;

        $currentDate = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
        
        $query = "INSERT INTO Comment (text, created_at, user_id, topic_id) VALUES (:text, :created_at, :user_id, :topic_id)";
        $args = [
            ':text' => $this->text,
            ':created_at' => $currentDate->format('d-m-Y H:i:s'),
            ':user_id' => $this->user_id,
            ':topic_id' => $this->topic_id
        ];

        $statement = $app->database->exec($query, $args);
    }


    public static function delete(int $id)
    {
        global $app;

        $query = "DELETE FROM Topic WHERE id = :id";
        $args = [
            ':id' => $id
        ];

        $statement = $app->database->exec($query, $args);
    }


    public static function getAllByTopic($topic_id)
    {
        global $app;

        $query = "SELECT c.id, c.text, c.created_at, u.username
            FROM Comment AS c
            LEFT JOIN User AS u
                ON c.user_id = u.id
            WHERE c.topic_id = :topic_id
            ORDER BY c.created_at ASC";
        $args = [
            ':topic_id' => $topic_id
        ];

        $statement = $app->database->exec($query, $args);
        $response = $statement->fetchAll();

        return $response;
    }


    public static function get(int $id)
    {
        global $app;

        $query = "SELECT t.id, t.title, t.description, t.created_at, u.username, COALESCE(v.nbVote, 0) AS nbVote
            FROM Topic AS t
            LEFT JOIN User AS u
                ON t.user_id = u.id
            LEFT JOIN (
                SELECT topic_id, COUNT(*) AS nbVote
                FROM Vote
                GROUP BY topic_id
            ) AS v ON t.id = v.topic_id
            WHERE t.id = :id";
        $args = [
            ':id' => $id
        ];

        $statement = $app->database->exec($query, $args);
        $response = $statement->fetch();

        return $response;
    }


    public static function getFamous()
    {
        global $app;

        $query = "SELECT t.id, t.title, t.description, t.created_at, u.username, COALESCE(v.nbVote, 0) AS nbVote
        FROM Topic AS t
        LEFT JOIN User AS u
            ON t.user_id = u.id
        LEFT JOIN (
            SELECT topic_id, COUNT(*) AS nbVote
            FROM Vote
            GROUP BY topic_id
        ) AS v ON t.id = v.topic_id
        ORDER BY nbVote DESC
        LIMIT(1)";
        $args = [];

        $statement = $app->database->exec($query, $args);
        $response = $statement->fetch();

        return $response;
    }


    public static function getAllByUser($user_id)
    {
        global $app;

        $query = "SELECT t.id, t.title, t.description, t.created_at, COALESCE(v.nbVote, 0) AS nbVote
        FROM Topic AS t
        LEFT JOIN (
            SELECT topic_id, COUNT(*) AS nbVote
            FROM Vote
            GROUP BY topic_id
        ) AS v ON t.id = v.topic_id 
        WHERE t.user_id = :user_id
        ORDER BY t.created_at ASC";

        $args = [
            ':user_id' => $user_id
        ];

        $statement = $app->database->exec($query, $args);
        $response = $statement->fetchAll();

        return $response;
    }
}