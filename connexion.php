<?php

$bdd = new PDO('mysql:host=localhost;dbname=projet3_gbaf','root','root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)); /*connexion à la bdd*/

if(isset($_POST['vconnexion']))
{

	$username = htmlspecialchars($_POST['username']);
	$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
	if(!empty($username) AND !empty($password))
	{
		if(preg_match('/^[a-zA-ZáàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆ-]+$/', $_POST['username']))
		{
			$reqprofil = $bdd->prepare('SELECT id_user, password FROM account WHERE username = :username');
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
							$erreur = "La connexion est possible !";
						}
					else 
						{
							$erreur = "Mauvais identifiant ou mot de passe 2 !";
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
<html>
	<head>
		<link rel="stylesheet" href="style.css" type="text/css" />
		<meta charset="utf-8"/>
		<title>page d'inscription</title> 
	</head>
		<body>
			<div align="center">
				<h2> Veuillez vous connecter :</h2>
				<form method="POST" action="">
					<table>
						<tr>
							<td align="right">
								<label for ="Nom">Votre Pseudo :</label>
							</td>
							<td>
								<input type="texte" placeholder="username" id="username" name="username" />
							</td>
						</tr><br />
							<tr>
								<td align="right">
									<label for ="Prenom">Votre Mot De Passe :</label>
								</td>
								<td>
									<input type="password" placeholder="password" id="password" name="password" />
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
								<td><br /><a href="Mot de Passe oublié ?">Mot de passe oublié ?</a>
								</td>

							</tr>
					</table>
				</form> </br>
				<?php
					if(isset($erreur))
					{
						echo '<font color="red">'.$erreur."</font>";
					}
				?>
			</div>
		</body>
			<footer>

			</footer>
</html>