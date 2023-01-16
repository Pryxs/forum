<?php

use App\core\Application; 
use App\models\Toast; 


?>
<div>
    <h2>Ajouter un topic</h2>

    <form action="/topic" method="post">
        <div>
            <label for="title">Titre : </label>
            <input type="text" name="title" id="title" required value="<?= $fields['title'] ?? '' ?>">
            <?php 
                if(isset($errors) && $errors['title']){
                    foreach ($errors['title'] as $error) {?>
                    <br>
                    <span class="alert"><?= $error; ?></span>
                    <?php }
                }
            ?>
        </div>
        <div>
            <textarea id="description" name="description"><?= $fields['description'] ?? '' ?></textarea>  
            <?php 
                if(isset($errors) && $errors['description']){
                    foreach ($errors['description'] as $error) {?>
                    <br>
                    <span class="alert"><?= $error; ?></span>
                    <?php }
                }
            ?>  
        </div>
        <div>
            <input type="submit" value="Ajouter">
        </div>
    </form>
</div>

<?php if($userTopics){ ?>
    <div class="user-topics">
        <h2>Vos topics</h2>

        <ul class="user-topics_list">
            <?php foreach($userTopics as $userTopic){ ?>
                <li class="user-topics_item">
                    <span><?= $userTopic['title'] ?></span>
                    <div class="user-topics_actions">
                        <a class="user-topics_actions_delete" href="/topic/edit?id=<?= $userTopic['id']?>">
                            <?= file_get_contents(Application::$ROOT_DIR . '/img/icones/edit.svg') ?>
                        </a>
                        <form id="form-delete-<?= $userTopic['id']?>" method="post" action="/topic/destroy">
                            <input name="id" value="<?= $userTopic['id']?>" type="hidden"/>
                            <a href="javascript:{}" onclick="confirmAction(event, '<?= $userTopic['title'] ?>', '<?= $userTopic['id'] ?>')">
                                <?= file_get_contents(Application::$ROOT_DIR . '/img/icones/delete.svg') ?>
                            </a>
                        </form>
                    </div>
            </li>
            <?php } ?>
        </ul>
    </div>
<?php } 

if(Toast::waitingToast()){ 
    echo Toast::mountToast();
} ?>

<script>
    function confirmAction(event, title, id){
        let confirmDialog = confirm('Vous allez supprimer le topic : ' + title);
        if(confirmDialog){
            document.getElementById('form-delete-' + id).submit();
            return false;
        } else {
            event.preventDefault();
        }
    }
</script>
