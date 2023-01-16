<main class="register-page">
  <h1>Créer un compte</h1>

  <form action="" method="post">
    <div>
      <label for="username">Nom : </label>
      <input type="text" name="username" id="username" required value="<?= $fields['username'] ?? '' ?>">

      <?php 
        if(isset($errors) && $errors['username']){
          foreach ($errors['username'] as $error) { ?>
            <br>
            <span class="alert"><?= $error; ?></span>
          <?php }
        }
      ?>

    </div>
    <div>
      <label for="password">Mot de passse : </label>
      <input type="password" name="password" id="password" required>

      <?php 
        if(isset($errors) && $errors['password']){
          foreach ($errors['password'] as $error) {?>
            <br>
            <span class="alert"><?= $error; ?></span>
          <?php }
        }
      ?>

    </div>
    <div>
      <label for="confirmPassword">Confirmer mot de passse : </label>
      <input type="password" name="confirmPassword" id="confirmPassword">

      <?php 
        if(isset($errors) && $errors['confirmPassword']){
          foreach ($errors['confirmPassword'] as $error) { ?>
            <br>
            <span class="alert"><?= $error; ?></span>
          <?php }
        }
      ?>

    </div>
    <div>
      <input type="submit" value="S'inscrire">
      <span><a href="/login">Connectez vous !</a></span>
    </div>
  </form>
</main>
