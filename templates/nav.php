<!-- Contains only the menu and the header -->

<nav role="navigation">
  <div id="menuToggle">
    <input type="checkbox" />

    <span></span>
    <span></span>
    <span></span>

    
    <ul id="menu">
      <a class="active" href="index.php"><li>Accueil</li></a>
      <a href="profile.php"><li>Mon Compte</li></a>
      <a href="#"><li>Mes Commandes</li></a>
      <a href="#"><li>L'équipe de la KFet</li></a>
      <a href="#"><li>Contact</li></a>
        
      <!--Pour les baristas :-->

      <hr>
      <a href="#"><li>Recharger un compte</li></a>
      <a href="#"><li>Ajouter une nouvelle personne</li></a>
      <a href="#"><li>Historique des commmandes</li></a>

      <!--Pour le boss-->

      <hr>
      <a href="administration.php"><li>Administrer</li></a>
        <div style="margin-left:20px;">
          <a href="administration.php#produits"><li>Gestion des produits</li></a>
          <a href="administration.php#usagers"><li>Gestion des utilisateurs</li></a>
          <a href="#"><li>Gestion de l'équipe</li></a>
          <a href="administration.php#statistiques"><li>Statistiques</li></a>
          <a href="#"><li>Modifier la page d'accueil</li></a>
        </div>

      <hr>
      <a href="logout.php"><li>Se Déconnecter</li></a>
    </ul>
  </div>
  <img class="logo" src="res/icon.svg" alt="Logo de la KFET">
  <span id="navspan"></span>
</nav>