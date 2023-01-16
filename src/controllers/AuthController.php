<?php
namespace App\controllers;

use App\core\Session;
use App\models\Toast;
use App\models\entities\User;

class AuthController
{
    public function login()
    {
        global $app;

        $user = new User($app->request->getData());
        $userExist = $user->exist();

        if($userExist){
            $session = new Session();
            $session->set(User::getByUsername($user->username));
            Toast::setToast('Bienvenu', '-success');
            header('location:/');
        } else {
            $params = [
                'error' => 'Nom de compte ou mot de passe incorrect',
                'fields' => [
                    'username' => $user->username
                ]
            ];
            
            return $app->router->renderView('login', false, $params);
        }
    }


    public function register()
    {
        global $app;

        $user = new User($app->request->getData());
        $errors = $user->isValide();

        if(count($errors) === 0){
            $user->create();
            header('location:/');
        } else {
            $params = [
                'errors' => $errors,
                'fields' => [
                    'username' => $user->username
                ]
            ];
            
            return $app->router->renderView('register', false, $params);
        };
    }


    public function logout()
    {
        $session = new Session();
        $session->clear();
        header('location:login');
    }
}