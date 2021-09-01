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
      <a href="#"><li>Mes Commandes</li></a>
      <a href="team.php"><li>L'équipe de la KFet</li></a>
      <a href="#"><li>Contact</li></a>
        
      <!--Pour les baristas :-->

      <hr>
      <a href="recharge_account.php"><li>Recharger un compte</li></a>
      <a href="add_user.php"><li>Ajouter une nouvelle personne</li></a>
      <a href="observe_commands.php"><li>Historique des commmandes</li></a>

      <!--Pour le boss-->

      <hr>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Administration</a>
        <div class="dropdown-menu">
          <a class="dropdown-item" href="administrate.php">Menu d'administration</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="administrate_products.php">Produits</a>
          <a class="dropdown-item" href="administrate_users.php">Utilisateurices</a>
          <a class="dropdown-item" href="administrate_baristas.php">Baristas</a>
          <a class="dropdown-item" href="administrate_stats.php">Statistiques</a>
          <a class="dropdown-item" href="administrate_events.php">Évévenements</a>

        </div>
      </li>

      <hr>
      <a href="lib/logout.php"><li>Se Déconnecter</li></a>

    </ul>
  </div>
  <img class="logo" src="res/icon.svg" alt="Logo de la KFET">
  <span id="navspan"></span>
</nav>