<?php

namespace App\models\entities;

use App\core\Session;  

class Topic extends BaseModel
{
    public const RULES = [
        'title' => [
            'required' => true,
            'min' => 4,
            'max' => 60,
        ],
        'description' => [
            'required' => true,
            'max' => 1000,
        ]
    ];

    public string $id;
    public string $title;
    public string $description;
    public array $errors = [];

    public function __construct($data){
        $this->id = $data['id'] ?? '';
        $this->title = $data['title'] ?? '';
        $this->description = $data['description'] ?? '';
        parent::__construct(self::RULES);
    }


    public function create()
    {
        global $app;

        $session = new Session();
        $auth = $session->get();

        $author = $auth['id'] ?? null;
        $currentDate = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
        
        $query = "INSERT INTO Topic (title, description, created_at, user_id) VALUES (:title, :description, :created_at, :user_id)";
        $args = [
            ':title' => $this->title,
            ':description' => $this->description,
            ':created_at' => $currentDate->format('d-m-Y'),
            ':user_id' => $author
        ];

        $statement = $app->database->exec($query, $args);
    }



    public function update()
    {
        global $app;

        
        $query = "UPDATE Topic 
        SET title = :title, description = :description
        WHERE id = :id";

        $args = [
            ':id' => $this->id,
            ':title' => $this->title,
            ':description' => $this->description,
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



    public static function getAll($excluded_id = false)
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
            WHERE t.id NOT IN (:excluded_id);
            ORDER BY t.created_at ASC";
        $args = [
            ':excluded_id' => $excluded_id
        ];

        $statement = $app->database->exec($query, $args);
        $response = $statement->fetchAll();

        return $response;
    }


    public static function get(int $id)
    {
        global $app;

        $query = "SELECT t.id, t.title, t.description, t.created_at, u.username, COALESCE(v.nbVote, 0) AS nbVote,  COALESCE(c.nbComment, 0) AS nbComment
            FROM Topic AS t
            LEFT JOIN User AS u
                ON t.user_id = u.id
            LEFT JOIN (
                SELECT topic_id, COUNT(*) AS nbVote
                FROM Vote
                GROUP BY topic_id
            ) AS v ON t.id = v.topic_id
            LEFT JOIN (
                SELECT topic_id, COUNT(*) AS nbComment
                FROM Comment
                GROUP BY topic_id
            ) AS c ON t.id = c.topic_id
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