<?php

namespace App\core;

class Request
{    

    public function __construct()
    {
    }

    // retourne le chemin sans paramètre
    public function getPath()
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $paramPosition = strpos($path, '?');

        if(!$paramPosition) return $path;

        return substr($path, 0, $paramPosition);
    }


    // retourne la méthode utilisé
    public function getMethod()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }


    public function getData()
    {
        $data = [];

        if($this->getMethod() === 'get'){
            foreach($_GET as $key => $value){
                $data[$key] = htmlentities($value);
            }
        }

        if($this->getMethod() === 'post'){
            foreach($_POST as $key => $value){
                $data[$key] = htmlentities($value);
            }
        }

        return $data;
    }
}