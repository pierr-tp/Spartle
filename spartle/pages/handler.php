<?php
session_start();
$_SESSION['pseudo'] = "Pierre";
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=spartlebd;charset=utf8', 'root', '');
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}
$task = "list";
if (array_key_exists("task", $_GET)) {
	$task = $_GET['task'];
}
if ($task == "write") {
	postMessage();
}
else {
	getMessages();
}

function getMessages(){
	global $bdd;
	$reponse = $bdd->query('SELECT * FROM publications ORDER BY ID DESC');
	$publications = $reponse->fetchAll();
	echo $publications;
}
function postMessage(){
	global $bdd;
	if (!array_key_exists("pseudo", $_SESSION) || !array_key_exists("message", $_POST)) {
		echo json_encode(["status" => "error", "content" => "Un champ ou plusieurs n'ont pas été envoyés !"]);
		return;
	}
	$pseudo = $_SESSION['pseudo'];
	$publication = $_POST['message'];
	$query = $bdd->prepare('INSERT INTO publications SET pseudo = :pseudo, publication = :publication, date_post = NOW()');
	$query->execute([
		"pseudo" => $pseudo,
		"publication" => $publication
	]);
	echo json_encode(["status" => "success"]);
}
?>