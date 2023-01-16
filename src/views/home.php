<?php 

use App\core\Application;

?>

<div  class="home-page">
    <main>
        <?php if($famous){ 
            include(Application::$ROOT_DIR . '/views/components/homeFamous.php');
        } 

        include(Application::$ROOT_DIR . '/views/components/homeTopics.php'); 
        
        ?>

    </main>

    <aside>
        <?php include(Application::$ROOT_DIR . '/views/components/homeAside.php'); ?>
    </aside>
</div>