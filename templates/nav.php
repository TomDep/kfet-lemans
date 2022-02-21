<!-- Contains only the menu and the header -->

<nav role="navigation" id="nav">
  <div id="menuToggle">
    <input type="checkbox" />

    <span></span>
    <span></span>
    <span></span>
    
    <ul id="menu">
      <a class="active" href="index.php"><li>Accueil</li></a>
      <a href="profile.php"><li>Mon Compte</li></a>
      <a href="my_commands.php"><li>Mes Commandes</li></a>
      <a href="team.php"><li>L'équipe de la KFet</li></a>
        
      <!--Pour les baristas :-->
<?php
  if(isset($_SESSION['auth_level'])) {
      if($_SESSION['auth_level'] >= 1) {
?>
      <hr>
      <a href="recharge_account.php"><li>Recharger un compte</li></a>
      <a href="add_user.php"><li>Ajouter une nouvelle personne</li></a>
      <a href="observe_commands.php"><li>Historique des commmandes</li></a>

      <!--Pour le boss-->
<?php
  }
  if($_SESSION['auth_level'] >= 2) {
?>
      <hr>

      <a href="administrate_products.php"><li>Produits</li></a>
      <a href="administrate_users.php"><li>Utilisateurices</li></a>
      <a href="administrate_baristas.php"><li>Baristas</li></a>
      <a href="#" class="unclickable"><li>Statistiques</li></a>
      <a href="administrate_events.php"><li>Évévenements</li></a>
  <?php }
  }
?>
      <hr>
      <a href="lib/logout.php"><li>Se Déconnecter</li></a>

    </ul>
  </div>
  <a href="index.php">
    <img class="logo" src="res/icon.svg" alt="Logo de la KFET">
  </a>
  <span id="navspan"></span>
</nav>