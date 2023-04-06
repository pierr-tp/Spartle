<!DOCTYPE html>
<html id="spartle" lang="fr">
<head>
	<meta charset="utf-8">
	<script defer src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
	<link rel="stylesheet" type="text/css" href="login.form.css">
	<title id="title">Spartle</title>
</head>
<body>
	<header class="header" role="header">
		<h1 class="logo">SPARTLE</h1>
		<h3 class="devise">Tous les sports en un réseau</h3>
	</header>
	<section class="login_form_page" role="section">
		<article class="login_form_page2" role="article">
			<h2 class="login_title">Connexion</h2>
			<hr class="line">

			<?php
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=spartlebd;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}
//  Récupération de l'utilisateur et de son pass hashé
$req = $bdd->prepare('SELECT id, password FROM members WHERE pseudo = :pseudo');
$req->execute(array(
    'pseudo' => $pseudo));
$resultat = $req->fetch();

// Comparaison du pass envoyé via le formulaire avec la base
$isPasswordCorrect = password_verify($_POST['password'], $resultat['password']);

if (!$resultat)
{
    $errors = 'Mauvais identifiant ou mot de passe !';
}
else
{
    if ($isPasswordCorrect) {
        session_start();
        $_SESSION['id'] = $resultat['id'];
        $_SESSION['pseudo'] = $pseudo;
        header('Location: spartle.php');
    }
    else {
        $errors = 'Mauvais identifiant ou mot de passe !';
    }
} 
			if (!empty($errors)) 
			{
			 	foreach ($errors as $error) 
			 	{
			 		echo "<h4><div class='error'>".$error."</div></h4>";	
			 	}
			 }
			 ?>
			<form class="login_form" method="post" action="login.post.php">
				<i class="fas fa-user-circle"></i>
				<input type="text" name="pseudo" class="pseudo" placeholder="Votre pseudo" required>
				<br>
				<i class="fas fa-unlock-alt"></i>
				<input type="password" name="password" class="password" placeholder="Votre mot de passe" required>
				<br>
				<input type="submit" name="submit" class="submit" value="C'est parti">
				<br>	
			</form>
		</article>
		<article class="registration_section" role="article">
			<p class="registration_question">Pas de compte ?</p>
			<a href="home.php" hreflang="fr" class="registration_link">S'inscrire</a>
		</article>
	</section>
</body>
</html>