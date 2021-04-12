<?php 

$bdd = new PDO('mysql:host=localhost;dbname=projet3_gbaf','root','root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)); /*connection à la bdd*/

if(isset($_POST['vnewmdp']))
{
	$username = htmlspecialchars($_POST['username']);
	$newpassword = password_hash($_POST['newpassword'], PASSWORD_DEFAULT);
	$question = htmlspecialchars($_POST['question']);
	$reponse = htmlspecialchars($_POST['reponse']);
		if(!empty($_POST['username']) AND !empty($_POST['newpassword']) AND !empty($_POST['question']) AND !empty($_POST['reponse'])) 
		{
			if(preg_match('/^[a-zA-Z0-9-_]{2,36}$/', $_POST['username']))
		   {
			$requser = $bdd->prepare("SELECT username, question, reponse FROM account WHERE username = ?");
			$requser->execute(array($username));
			$userinfo = $requser->fetch();

				if($question == $userinfo['question'] AND $reponse == $userinfo['reponse'])
				{
					$newpass_hash = password_hash($_POST['newpassword'], PASSWORD_DEFAULT);
					$updatepassword = $bdd->prepare("UPDATE account SET password = ? WHERE username = ?");
					$updatepassword->execute(array($newpass_hash, $userinfo['username']));
					$erreur = "le mot de passe à été mis à jour ! ";
				} else {$erreur = "La réponse à la question n'est pas correct !";}	
			} else {$erreur = "Votre pseudo contient un caractère non valide !";} 
		} else {$erreur = "Tous les champs doivent être remplis !";}
}	


?>
<!DOCTYPE html>
<html>
	<head>
		<head>
		<link rel="stylesheet" href="style.css" type="text/css" />
		<meta charset="utf-8"/>
		<link rel="icon" href="images/favicon_gbaf.ico" />
			<title>Mot de passe oublié ?</title> 		
				<div >
				<figure>
						<img style="max-width:80px"; src="images/logo_gbaf.png" alt="logo de gbaf" />
				</figure>
				</div>
	</head>
		<body>
			<div align="center">
				<h2> Mot de passe oublié ? merci de remplir les champs suivants :</h2>
				<form method="POST" action="">
					<table>
						<tr>
							<td align="right">
								<label for ="username">Veuillez saisir votre pseudo :</label>
							</td>
							<td>
								<input type="texte" placeholder="username" id="username" name="username" />
							</td>
						</tr><br />
							<tr>
								<td align="right">
								<label for="question">Quelle était votre question secrète :</label><br />
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
									<label for ="reponse">Répondez à la question secrète :</label>
								</td>
								<td>
									<input type="texte" placeholder="reponse" id="reponse" name="reponse" />
								</td>
							</tr><br /> 
							<tr>
							<td align="right">
								<label for ="password">Confirmez votre nouveau mot de passe :</label>
							</td>
							<td>
								<input type="password" placeholder="Nouveau mot de passe" id="newpassword" name="newpassword" />
							</td>
							</tr><br />
							<tr>
								<td></td>
								<td><br />
									<input type="submit" name="vnewmdp" value="valider nouveau mot de passe" />
								</td>
							</tr>
					</table> <br/><a href="connexion.php">Retour à la page de connexion</a> 
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