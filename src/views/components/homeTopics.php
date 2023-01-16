<?php 

use App\core\Application; 

?>
<div class="topic-list">
    <h1>Nos topics</h1>
    <?php 
        if($topics){
            foreach($topics as $topic){ ?>
                <a class="topic-container" href="/topic/view?id=<?= $topic['id'] ?>">
                    <div class="topic-container_content">
                        <h3><?= $topic['title'] ?></h3>

                        <p>
                            <?= $topic['description'] ?>
                        </p>

                        <div class="topic-container_content_infos">
                            <span><?= $topic['username'] ?></span>
                            <span><?= $topic['created_at'] ?></span>
                        </div>
                    </div>

                    <div class="topic-container_action <?= isset($topic['voted']) ? '-up' : '' ?>">
                        <form action="/vote" method="post">
                            <input type="hidden" name="topic_id" value="<?= $topic['id'] ?>"/>
                            <label>
                                <input type="submit" value="">
                                <?= file_get_contents(Application::$ROOT_DIR . '/img/icones/up.svg') ?>
                            </label>
                        </form>
                        
                        <span><?= $topic['nbVote'] ?></span>
                    </div>
                </a>
            <?php }
        }
    ?>
</div>