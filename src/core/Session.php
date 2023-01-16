<?php

namespace App\core;

class Session
{

    public function __construct()
    {
        if(session_status() === PHP_SESSION_NONE) session_start();
    }


    public function get()
    {
        if($_SESSION['Auth']) return $_SESSION['Auth'];

        return null;
    }


    public function set($user)
    {
        $_SESSION['Auth'] = [
            'username' => $user['username'],
            'id' => $user['id'],
            'authority' => $user['authority']
        ];     
    }


    public function clear(): void
    {
        session_destroy();
        // session_unset();
        // unset($_SESSION['Auth'])
    }
}
