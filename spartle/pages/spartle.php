<?php 
session_start();
$_SESSION['pseudo'] = "Pierre";
if (empty($_SESSION['pseudo'])) 
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
	<link rel="stylesheet" type="text/css" href="spartle.css">
	<title id="title">Spartle</title>
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
		</ul>
	</nav>
	<section role="section">
		<article role="article" class="publication_area">
			<form class="publication_area_form" method="post" action="handler.php?task=write">
				<textarea name=message class="publication_area_write" id="publication_area_write" placeholder="<?php echo $_SESSION['pseudo'];?>, que faites-vous ?"></textarea>
				<br>
				<div class="notext">
				<a href="" title="Publier une image"><i class="fas fa-images"></i></a>
				<a href="" title="Publier une video"><i class="fas fa-video"></i></a>
				<a href="" title="Choisissez des émoticônes"><i class="fas fa-smile"></i></a><select class="publication_parameters" title="Comment voulez-vous la publiez ?">
					<option value="private" title="Il n'y que vous qui peut la voir">Privé</option>
					<option value="public" title="Tout le monde peut la voir">Public</option>
					<option value="folowing" title="Il n'y a que vous et vos abonnés qui peuvent la voir">Mes abonnés</option>
					<option value="folowers" title="Il n'y a que vous et ce auquels vous êtes abonné qui peuvent la voir">Ceux que je suis</option>
					<option value="folowing&folowers" title="Il n'y a que vous, vos abonnés et ce auquels vous êtes abonné qui peuvent la voir">Mes abonnés et ceux que je suis</option>
					<option value="other" title="Autes choix">Autre</option>
				</select>
			</div>
			<input type="submit" name="send" class="send" value="Envoyer" title="Envoyer">
			</form>
			<br>
		</article>
				<article>
		<div class="publis">
			<div class="p-pseudo">
			</div>
			<div class="p-datepost">
			</div>
			<hr class="line">
			<div class="p-content">
			</div>
			<button class="like" title="Liker"><i class="far fa-heart"></i></button>
			<button class="comment" title="Commenter"><i class="far fa-comment"></i></button>
			<button class="share" title="Partager"><i class="fas fa-share-square"></i></button>
			<button class="more" title="Plus"><i class="fas fa-plus"></i></button>
		</div>
		</article>
	</section>
	<script type="text/javascript">
		function getMessages() {
			const reqAjax = new XMLHttpRequest();
			reqAjax.open("GET", "handler.php");
			reqAjax.onload = function() {
				const html = reqAjax.responseText;
				const publications = document.querySelector(".publis");
				publications.innerHTML = html;
			}
			reqAjax.send();
		}
		function postMessage(e) {
			const pseudo = "<?php echo $_SESSION["pseudo"];?>";
			const publication = document.querySelector("#publication_area_write");
			const data = new FormData();
			data.append('pseudo', pseudo.value);
			data.append('publication', publication.value);
			const reqAjax = new XMLHttpRequest();
			reqAjax.open("POST", "handler.php?task=write");
			reqAjax.onload = function(){
				getMessages();
			}
			reqAjax.send(data);
		}
		document.querySelector("form").addEventListener("submit", postMessage());
	</script>
</body>
</html>
<?php
}
?>