<?php
try
{
    $bdd = new PDO('mysql:host=localhost;dbname=spartlebd;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}
if (!empty($_POST['pseudo']) and !empty($_POST['password']))
{
    $pseudo = htmlspecialchars($_POST['pseudo']);
    $pass_hache = htmlspecialchars(sha1($_POST['password']));
    $req = $bdd->prepare('SELECT id FROM members WHERE pseudo = :pseudo AND password = :password');
    $req->execute(array(
        'pseudo' => $pseudo,
        'password' => $pass_hache));

    $resultat = $req->fetch();
    if ($resultat == 1) 
    {
        session_start();
        $_SESSION['id'] = $resultat['id'];
        $_SESSION['pseudo'] = $pseudo;
        header('Location: spartle.php');    
    }
    else
    {
        $errors = "Pseudo ou mot de passe incorrect !";
        header('Location: login.form.php');
    }
}
else
{
    $errors = "Vous devez remplir le formulaire !";
    header('Location: login.form.php');
}
?>