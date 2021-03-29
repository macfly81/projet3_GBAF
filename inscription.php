<?php

$bdd = new PDO('mysql:host=localhost;dbname=projet3_gbaf','root','root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)); /*connection à la bdd*/

if(isset($_POST['vinscription']))
{
	$nom = htmlspecialchars($_POST['nom']);
	$prenom = htmlspecialchars($_POST['prenom']);
	$username = htmlspecialchars($_POST['username']);
	$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
	$question = htmlspecialchars($_POST['question']);
	$reponse = htmlspecialchars($_POST['reponse']);
if(!empty($_POST['nom']) AND !empty($_POST['prenom']) AND !empty($_POST['username']) AND !empty($_POST['password']) AND !empty($_POST['question']) AND !empty($_POST['reponse'])) /*insertion du REGEX pour le nom, prenom, username*/
    {	
	if(preg_match('/^[a-zA-ZáàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆ-]+$/', $_POST['nom']) AND preg_match('/^[a-zA-ZáàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆ-]+$/', $_POST['prenom']))
	{
	if(preg_match('/^[a-zA-Z0-9-_]{2,36}$/', $_POST['username']))
	   {
		$requsername = $bdd->prepare("SELECT * FROM account WHERE username = ?");
		$requsername->execute(array($username));
		$userexist = $requsername->rowCount(); /*requete pour éviter les doublons de pseudonymes*/
		if($userexist == 0)
		{
				$pass_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
				$insertmembres = $bdd->prepare("INSERT INTO account(nom, prenom, username, password, question, reponse) VALUES(:nom, :prenom, :username, :password, :question, :reponse)");
				$insertmembres->execute(array(
					'nom' => $nom,
					'prenom' => $prenom,
					'username' => $username,
					'password' => $pass_hash,
					'question' => $question,
					'reponse' => $reponse));
				$erreur = "votre compte a bien été crée ! <a href=\"connexion.php\">Me connecter</a>";
		} else
			{
			$erreur = "ce pseudonyme existe déjà";
			}
		} else
			{
			$erreur = "votre pseudonyme doit contenir entre 2 et 36 caractères et être au format alphanumérique !";
			}
		} else 
			{
			$erreur = "Le champ : nom ou prénom, contient un caractère non valide !";
			}
		} else
			{
				$erreur = "Tous les champs doivent être remplis !";
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
				<h2> Veuillez remplir les champs suivants pour l'inscription :</h2>
				<form method="POST" action="">
					<table>
						<tr>
							<td align="right">
								<label for ="Nom">Votre nom :</label>
							</td>
							<td>
								<input type="texte" placeholder="nom" id="nom" name="nom" />
							</td>
						</tr><br />
							<tr>
								<td align="right">
									<label for ="Prenom">Votre prenom :</label>
								</td>
								<td>
									<input type="texte" placeholder="prenom" id="prenom" name="prenom" />
								</td>
							</tr><br />
						<tr>
							<td align="right">
								<label for ="username">Votre pseudo :</label>
							</td>
							<td>
								<input type="texte" placeholder="username" id="username" name="username" />
							</td>
						</tr><br />
							<tr>
							<td align="right">
								<label for ="password">Votre mot de passe :</label>
							</td>
							<td>
								<input type="password" placeholder="mot de passe" id="password" name="password" />
							</td>
						</tr><br />
							<tr>
								<td align="right">
								<label for="question">Question secrète :</label><br />
								</td>
								<td>
									<select name="question" id="question">
										<option value="Quel est votre livre préféré">Quel est votre livre préféré ?</option>
										<option value="Quel est le nom de votre animal de compagnie">Quel est le nom de votre animal de compagnie ?</option>
										<option value="quel est le nom de jeune fille de votre mère">Quel est le nom de jeune fille de votre mere ?</option>
									</select>
								</td>
						</tr><br />
							<tr>
								<td align="right">
									<label for ="reponse">réponse à la question secrète :</label>
								</td>
								<td>
									<input type="texte" placeholder="reponse" id="reponse" name="reponse" />
								</td>
							</tr>
							<tr>
								<td></td>
								<td>
									<input type="submit" name="vinscription" value="valider l'inscription" />
								</td>
						</tr><br /><br /> 
					</table> <br/><a href="connexion.php">Retourner à la page de connexion</a> 
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