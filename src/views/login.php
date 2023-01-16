<main class="login-page">
  <h1>Se connecter</h1>

  <form action="" method="post">
    <?php 
      if(isset($error)){ ?>
          <span class="alert -top"><?= $error; ?></span>
      <?php }
    ?>
    <div>
      <label for="username">Nom : </label>
      <input type="text" name="username" id="username" required value="<?= $fields['username'] ?? '' ?>">
    </div>
    <div>
      <label for="password">Mot de passse : </label>
      <input type="password" name="password" id="password" required>
    </div>
    <div>
      <input type="submit" value="Se connecter">
      <span>Pas encore de compte ? <a href="/register">Inscivez vous !</a></span>
    </div>
  </form>
</main>
