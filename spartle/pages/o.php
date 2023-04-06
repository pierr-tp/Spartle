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
						<script type="text/javascript">
				function deactivateErrors() 
				{

				    var errors = document.querySelectorAll('.errors'),
				        errorsLength = errors.length;

				    for (var i = 0; i < errorsLength; i++) 
				    {
				        errors[i].style.display = 'none';
				    }

				}
				function getErrors(element) 
				{
    
					while (element = element.nextSibling) {
					    if (element.className === 'errors') {
					        return element;
				    	}
					}
					
					return false;
					
				}
				var check = {};
				check['pseudo'] = function()
				{
    
					var pseudo = document.getElementsByClassName('pseudo'),
					    pseudoStyle = getErrors(pseudo).style;
					
					if (pseudo.value.length >= 1)
					{
				    	pseudo.className = 'correct';
				    	pseudoStyle.display = 'none';
				    	return true;
					} 
					else 
					{
				    	pseudo.className = 'incorrect';
				    	pseudo.display = 'inline-block';
				    	return false;
					}					
				};
				check['email'] = function()
				{
    
					var email = document.getElementsByClassName('email'),
					    emailStyle = getErrors(email).style;
					
					if (email.value.length >= 1)
					{
				    	email.className = 'correct';
				    	emailStyle.display = 'none';
				    	return true;
					} 
					else 
					{
				    	email.className = 'incorrect';
				    	email.display = 'inline-block';
				    	return false;
					}					
				};
				check['password'] = function()
				{
					var password = document.getElementsByClassName('password'),
						passwordStyle = getErrors(password).style;

					if (password.value.length >= 1) 
					{
						password.className = 'correct';
						passwordStyle.display = 'none';
						return true;
					}
					else
					{
						password.className = 'incorrect';
						password.display = 'inline-block';
						return false;
					}
				};
				(function() 
				{ 

				    var myForm = document.getElementsByClassName('registration_form'),
				        inputs = document.querySelectorAll('input[type=text], input[type=email] input[type=password]'),
				        inputsLength = inputs.length;

				    for (var i = 0; i < inputsLength; i++) 
				    {
				        inputs[i].addEventListener('keyup', function(e) 
				        {
				            check[e.target.class](e.target.class);
				        });
				    }

				    myForm.addEventListener('submit', function(e) 
				    {

				        var result = true;

				        for (var i in check) {
				            result = check[i](i) && result;
				        }

				        if (result) 
				        {
				            alert('Le formulaire est bien rempli.');
				        }

				        e.preventDefault();

				    });
				})();
				deactivateErrors();
			</script>	