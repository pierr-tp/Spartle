<?php 
session_start();
if ($_SESSION['pseudo'] == 1) 
{
	header('Location: login.form.php');
}
else
{
?>
<!DOCTYPE html>
<html id="spartle" lang="fr">
<head>
	<meta charset="utf-8">
	<script defer src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
	<link rel="stylesheet" type="text/css" href="profile.css">
	<title id="title"><?php echo $_SESSION['pseudo'];?></title>
</head>
<body>
	<header class="header" role="header">
		<a href="spartle.php"><h1 class="logo" title="Accueil">SPARTLE</h1></a>
	</header>
	<form class="search_form" method="post" action="search.php">
		<input type="search" name="search" class="search" placeholder="Rechercher..." title="Rechercher">
	</form>
	<nav role="nav" class="menu">
		<ul class="list_menu">
			<li class="element_menu_list" title="Voir votre profil"><i class="fas fa-user"></i><a href="profile.php" hreflang="fr">Profil</a></li>
			<li class="element_menu_list" title="Voir mes moments"><i class="fas fa-clock"></i><a href="">Moments</a></li>
			<li class="element_menu_list" title="Voir des suggestions"><i class="fas fa-users"></i><a href="">Suggestions</a></li>
			<li class="element_menu_list" title="Créer une histoire"><i class="fas fa-history"></i><a href="">Histoire</a></li>
			<li class="element_menu_list" title="Créer un carnet de route"><i class="fas fa-suitcase"></i><a href="">Carnet de route</a></li>
			<li class="element_menu_list" title="Voir les paramètres"><i class="fas fa-cog"></i><a href="">Paramètres</a></li>
			<li class="element_menu_list" title="Se déconnecter"><i class="fas fa-power-off"></i><a href="deconnection.php">Déconnexion</a></li>
		</ul>
	</nav>
	<section role="section" class="profile_section">
		<article role="article" class="profile_title">
			
		</article>
	</section>
</body>
</html>
<?php
}
?>