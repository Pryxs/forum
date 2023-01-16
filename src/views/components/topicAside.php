<div>
    <h2>Derniers en date</h2>

    <ul class="user-topics_list">
    <?php foreach($latestTopics as $latestTopic){ ?>
        <li>
            <div class="user-topics_item">
                <span><?= $latestTopic['title'] ?></span>
                <span><?= $latestTopic['nbVote'] ?></span>
            </div>

            <a href="/topic/view?id=<?= $latestTopic['id'] ?>">Voir</a>
        </li>
    <?php } ?>
    </ul>
</div>