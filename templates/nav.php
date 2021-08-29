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
      <a href="#"><li>Ajouter une nouvelle personne</li></a>
      <a href="#"><li>Historique des commmandes</li></a>

      <!--Pour le boss-->

      <hr>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Administration</a>
        <div class="dropdown-menu">
          <a class="dropdown-item" href="administration.php">Menu administration</a>

          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="administration.php#produits">Gestion des produits</a>
          <a class="dropdown-item" href="administration.php#usagers">Gestion des utilisateurs</a>
          <a class="dropdown-item" href="administration/manage_team.php">Gestion de l'équipe</a>
          <a class="dropdown-item" href="administration.php#statistiques">Statistiques</a>
          <a class="dropdown-item" href="#">Modifier la page d'accueil</a>

        </div>
      </li>

      <hr>
      <a href="library/logout.php"><li>Se Déconnecter</li></a>

    </ul>
  </div>
  <img class="logo" src="res/icon.svg" alt="Logo de la KFET">
  <span id="navspan"></span>
</nav>