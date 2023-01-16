<?php 

use App\core\Application; 

?>
<a class="topic-container -famous"  href="/topic/view?id=<?= $famous['id'] ?>">
    <div class="topic-container_image">
        <img height="150" src="../img/coupe.png" alt="coupe"/>
    </div>
    <div class="topic-container_content">
        <h3><?= $famous['title'] ?></h3>

        <p>
            <?= $famous['description'] ?>
        </p>

        <div class="topic-container_content_infos">
            <span><?= $famous['username'] ?></span>
            <span><?= $famous['created_at'] ?></span>
        </div>
    </div>

    <div class="topic-container_action <?= isset($famous['voted']) ? '-up' : '' ?>">
        <form action="/vote" method="post">
            <input type="hidden" name="topic_id" value="<?= $famous['id'] ?>"/>
            <label>
                <input type="submit" value="">
                    <?= file_get_contents(Application::$ROOT_DIR . '/img/icones/up.svg') ?>
            </label>
        </form>
        
        <span><?= $famous['nbVote'] ?></span>
    </div>
</a>
