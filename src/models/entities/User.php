<?php

namespace App\models\entities;


class User extends BaseModel
{
    public const RULES = [
        'username' => [
            'required' => true,
            'min' => 4,
            'max' => 20,
            'unique' => true
        ],
        'password' => [
            'required' => true,
            'min' => 4,
            'max' => 20,
            'match' => 'confirmPassword'
        ],
        'confirmPassword' => [
            'required' => true,
        ]
    ];

    public string $username;
    public string $password;
    public string $confirmPassword;

    public function __construct($data){
        $this->username = $data['username'] ?? '';
        $this->password = $data['password'] ?? '';
        $this->confirmPassword = $data['confirmPassword'] ?? '';
        parent::__construct(self::RULES);
    }


    public static function getByUsername(string $username)
    {
        global $app;
        
        $query = "SELECT * FROM User WHERE username = :username";
        $args = [
            ":username" => $username
        ];

        $statement = $app->database->exec($query, $args);
        $response = $statement->fetch();

        return $response;
    }


    // TODO : catch error 
    public function create()
    {
        global $app;

        $passwordHash = password_hash($this->password, PASSWORD_DEFAULT);
        
        $query = "INSERT INTO User (username, password, authority) VALUES (:username, :password, :authority)";
        $args = [
            ':username' => $this->username,
            ':password' => $passwordHash,
            ':authority' => 1
        ];

        $response = $app->database->exec($query, $args);
    }

    public function exist()
    {
        $user = self::getByUsername($this->username);

        if($user){
            return password_verify($this->password, $user['password']) ? true : false;  
        }

        return false;
    }
}