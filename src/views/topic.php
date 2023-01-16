<?php 

use App\core\Application;

?>

<div class="topic-page">
    <main>
        <div class="topic-page_content">
            <h2><?= $topic['title'] ?></h2>
            <p><?= $topic['description'] ?></p>
            <div>
                <span><?= $topic['username'] ?></span>
                <span><?= $topic['created_at'] ?></span>
            </div>
        </div>

        <div class="topic-page_comments">
            <h3><?= $topic['nbComment'] ?> Commentaires</h3>
            <form method="post" action="/comment">
                <input type="hidden" name="topic_id" value="<?= $topic['id'] ?>"/>
                <input type="text" name="text" placeholder="Ajouter un commentaire" required="true"/>
                <input type="submit" value="Commenter"/>
            </form>
            <?php
                if($comments){
                    include(Application::$ROOT_DIR . '/views/components/topicComments.php'); 
                } 
            ?>
        </div>
    </main>


    <aside>
        <?php include(Application::$ROOT_DIR . '/views/components/topicAside.php'); ?>
    </aside>
</div>