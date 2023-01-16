<?php

use App\models\helpers\DateHelper;

?>

<div class="comments-container">
    <ul class="comments_list">
<?php
    foreach($comments as $comment){ ?>
    <li>
        <div class="comments_list_item">
            <div class="comments_list_item_infos">
                <span><?= $comment['username'] ?></span>
                <span><?= DateHelper::dateToTime($comment['created_at']) ?></span>
            </div>
            <p>
                <?= $comment['text'] ?>
            </p>
        </div>
    </li>
    <?php }?>
    </ul>
</div>