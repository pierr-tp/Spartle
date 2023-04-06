<!DOCTYPE html>
<html id="vacidea" lang="fr">
<head>
	<meta charset="utf-8">
	<script defer src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
	<link rel="stylesheet" type="text/css" href="home.css">
	<title id="title">Vacidea</title>
</head>
<body>
	<header class="header" role="header">
		<h1 class="logo">Vacidea</h1>
		<h3 class="devise">Laissez vous inspirez par nos conseils</h3>
	</header>
	<form class="search_form" method="post" action="">
		<input type="search" name="search" class="search" placeholder="Dites-nous votre destination..." title="Rechercher">
	</form>
	<section>
			<article>
			<?php
			try
			{
				$bdd = new PDO('mysql:host=localhost;dbname=vacideadb;charset=utf8', 'root', '');
			}
			catch(Exception $e)
			{
			        die('Erreur : '.$e->getMessage());
			}
			$reponse = $bdd->query('SELECT message, date_post FROM publications ORDER BY ID DESC');
			while ($donnees = $reponse->fetch())
			{
			?>
		<div class="publis">
			<?php
				echo '<h4 class="date_publis">Publié le '.htmlspecialchars($donnees['date_post']).'</h4>';
				echo '<p class="message">'.htmlspecialchars($donnees['message']).'</p>';
			?>
		</div>
			<?php
			}
			$reponse->closeCursor();
			?>
		</article>
		<article>
			<p>Envie de racontez un séjour que vous avez fait ?</p>
			<a href="editstart.php">Ecrivez-le !</a>
		</article>
	</section>
</body>
</html>