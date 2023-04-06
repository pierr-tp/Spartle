<?php
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=spartlebd;charset=utf8', 'root', '');
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}
if (!empty($_POST['message'])) 
{
$req = $bdd->prepare('INSERT INTO publications (pseudo, publication, date_post) VALUES(?, ?, CURDATE())');
$req->execute(array($_SESSION['pseudo'], $_POST['message']));
}
else
{
	?>
	<script type="text/javascript">
		alert("Vous n'avez rien écrit ! Dites quelque chose.");
	</script>
	<?php
}
?>