<?php 

use App\core\Application; 
use App\core\Permission;  
use App\core\Session;  

session_start(); 
?>
<div class="navigation">
    <?php 
        // $t = file_get_contents(Application::$ROOT_DIR . '/img/logo.svg'); 
        // echo $t; 
    ?>

    <nav>
        <ul>
            <?= !Permission::hasPermission('view', 'home') ?: '<li><a href="/">' . file_get_contents(Application::$ROOT_DIR . '/img/icones/logo.svg') .'</a></li>'?>
            <?= !Permission::hasPermission('view', 'home') ?: '<li><a href="/">' . file_get_contents(Application::$ROOT_DIR . '/img/icones/manage.svg') .'</a></li>'?>
        </ul>
    </nav>

    <?php 
        $session = new Session();
        $auth = $session->get();

        if($auth['username']){ ?>

        <div class="profile">
            <a href=<?= '/logout' ?>>
                <?= file_get_contents(Application::$ROOT_DIR . '/img/icones/logout.svg') ?>
            </a>

            <span><?= $auth['username'] ?></span>
        </div>

        <?php } 
?>
</div>

