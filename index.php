<?php
session_start();

$bdd = new PDO('mysql:host=localhost;dbname=projet3_gbaf','root','root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)); /*connexion à la bdd*/

if(isset($_POST['vconnexion']))
{

	$username = htmlspecialchars($_POST['username']);
	$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
	if(!empty($username) AND !empty($password))
	{
		if(preg_match('/^[0-9a-zA-ZáàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆ-]+$/', $_POST['username']))
		{
			$reqprofil = $bdd->prepare('SELECT id_user, nom, prenom, password, question, reponse FROM account WHERE username = :username');
			$reqprofil->execute(array(
				'username' => $username));
			$profilexist = $reqprofil->fetch();
			{
				if(!$profilexist)
				{
					$erreur = "Mauvais identifiant ou mot de passe !";
				}   
				else
					{
					$PasswordCorrect = password_verify($_POST['password'], $profilexist['password']);
					if($PasswordCorrect)
						{
							$_SESSION['id_user'] = $profilexist['id_user'];
							$_SESSION['username'] = $username;
							$_SESSION['nom'] = $profilexist['nom'];
							$_SESSION['prenom'] = $profilexist['prenom'];
							$_SESSION['question'] = $profilexist['question'];
							$_SESSION['reponse'] = $profilexist['reponse'];
							$_SESSION['password'] = $profilexist['password'];
							header("Location:profil.php");
							$erreur = "tout est bon !";

						}
					else 
						{
							$erreur = "Mauvais identifiant ou mot de passe !";
						}
					}	
			}			
		}
		else
			{
				$erreur = "Votre Pseudonyme contient des caractères non autorisées";
			}

	}
	else
		{
			$erreur = "Merci de completer tous les champs !";
		}
}
		
?>

<!DOCTYPE html>
<html lang="fr">
	<head>
		<title>page de connexion</title> 
		<link rel="stylesheet" href="style.css" type="text/css" />
		<meta charset="utf-8"/>
		<meta name=viewport content="width=device-width, initial-scale=1">
	</head>
		<body>
			<header>
				<figure>
					<img style="max-width:80px" src="images/logo_gbaf.png" alt="logo de gbaf" />
				</figure>
			</header>
			<div class="miseenpage">
				<h2> Veuillez vous connecter :</h2>
				<form method="POST">
						<tr>
							<td>
								<label>Votre Pseudo :</label>
							</td><br/><br/>
							<td>
								<input class="champ_connexion" type="text" placeholder="username" id="username" name="username" />
							</td><br/><br/>
						</tr>
							<tr>
								<td class="tdright">
									<label>Votre Mot De Passe :</label>
								</td><br /><br />
								<td>
									<input class="champ_connexion" type="password" placeholder="password" id="password" name="password" />
								</td>
							</tr><br />
						
							<tr>
								<td></td> 
								<td> <br />
									<input type="submit" name="vconnexion" value="Connexion" />
								</td>
							</tr>
						</tr><br />
							<tr>
								<td></td>
								<td><br /><a href="mdpforget.php">Mot de passe oublié ?</a>
								</td>

							</tr>
								<td></td>
								<td><br /><p> Vous êtes nouveau ? Merci de vous <a href="inscription.php">inscrire</a>.</p>
								</td>
				 </br>
				<?php
					if(isset($erreur))
					{
						echo $erreur;
					}
				?>
			</div>
				<footer>
					| Mentions légales | | Contact |
				</footer>
		</body>
</html>