<?php 

use App\core\Application;

include(Application::$ROOT_DIR . '/views/components/header.php'); ?>

<header>
    <?php include(Application::$ROOT_DIR . '/views/components/navigation.php'); ?>
</header>

{{content}}

<?php 

include(Application::$ROOT_DIR . '/views/components/footer.php');