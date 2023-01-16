<main class="topic-edit-page">
    <form method="post" action="/topic/update">
        <div>
            <span><?= $topic['username'] ?></span>
            <span><?= $topic['created_at'] ?></span>
        </div>

        <input name="id" type="hidden" value="<?= $topic['id']?>" />
        <input name="title" type="text" value="<?= $topic['title']?>" />
        <textarea name="description"><?= $topic['description'] ?></textarea>

        <input type="submit" value="Sauvegarder" /> 
    </form>
</main>