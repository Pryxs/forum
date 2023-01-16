<?php

namespace App\core;

use App\core\Session;

class Permission
{    
    public const PERMISSIONS = [
        'view' => [
            'login' => 0,
            'register' => 0,
            'home' => 1,
            'topic' => 1,
            'user_management' => 2
        ],
        
    ];

    public static function hasPermission($permissionContext, $permissionName)
    {
        $currentAuthority = 0;

        $session = new Session();
        $auth = $session->get();
        if($auth) $currentAuthority = $auth['authority'];

        $requiredAuthority = self::PERMISSIONS[$permissionContext][$permissionName];

        return $currentAuthority >= $requiredAuthority ? true : false;
    }
}