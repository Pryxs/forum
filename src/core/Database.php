<?php

namespace App\core;

class Database
{    
    public \PDO $pdo;

    public function __construct($dsn)
    {
        try{
            $this->pdo = new \PDO($dsn);
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->pdo->exec( 'PRAGMA foreign_keys = ON;' ); // permet de supprimer/editer en cascade
        } catch(PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }


    public function exec(string $query, array $args)
    {
        try{
            $req = $this->pdo->prepare($query);
            $req->execute($args);

            return $req;
        } catch(PDOException $e){
            $message = $e->getMessage();
            echo $message;
            die();
        }
    }
}