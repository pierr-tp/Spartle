			<?php
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=spartlebd;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}
if (!empty($_POST['pseudo']) and !empty($_POST['email']) and !empty($_POST['password']))
{
	$pseudo = htmlspecialchars($_POST['pseudo']);
	$email = htmlspecialchars($_POST['email']);
	$password = htmlspecialchars($_POST['password']);

	$req1 = $bdd->query('SELECT COUNT(*) AS existe_pseudo FROM members WHERE pseudo = "'.$_POST['pseudo'].'"');

	while ($sql1 = $req1->fetch()) 
	{
		if ($sql1['existe_pseudo'] == '0')
		{
			$req2 = $bdd->query('SELECT COUNT(*) AS existe_email FROM members WHERE email = "'.$_POST['email'].'"');
			while ($sql2 = $req2->fetch()) 
			{
				if ($sql2['existe_email'] == '0')
				{
					if (preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $_POST['email'] ))
					{
						$pass_hache = sha1($_POST['password']);
						$req3 = $bdd->query('SELECT COUNT(*) AS existe_password FROM members WHERE password = "'.$pass_hache.'"');

						while ($sql3 = $req3->fetch()) 
						{
							if ($sql3['existe_password'] == '0')
							{
								$req = $bdd->prepare('INSERT INTO members(pseudo, email, password, date_inscription) VALUES(:pseudo, :email, :password, CURDATE())');
								$req->execute(array(
								    'pseudo' => $pseudo,
								    'email' => $email,
									'password' => $pass_hache));
									session_start();
									$_SESSION['pseudo'] = $pseudo;
									$_SESSION['email'] = $email;
									$_SESSION['password'] = $pass_hache;
									header('Location: spartle.php');
							}
							else
							{
								$errors[] = "Désolé ! Ce mot de passe existe déjà .";
							}
						}
					}	
					else
					{
						$errors[] = "Cet email est incorrecte !";
					}
				}
				else
				{
					$errors[] = "Cet email existe déjà !";
				}
			}
		}
		else
		{
			$errors[] = "Désolé ! Ce pseudo existe déjà .";
		}
	}
}
else
{
	$errors2[] = "Vous devez remplir le formulaire .";
}
			if (!empty($errors)) 
			{
			 	foreach ($errors as $error) 
			 	{
			 		echo "<h4><div class='error'>".$error."</div></h4>";	
			 	}
			 }
			 elseif (!empty($error2)) 
			 {
			 	foreach ($errors2 as $error2) 
			 	{
			 		echo "<h4><div class='error2'>".$error2."</div></h4>";
			 	}
			 }
			?>