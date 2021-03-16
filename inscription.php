<?php
$bdd = new PDO('mysql:localhost;dbname=account','root','root');

if(isset($_POST['vinscription']))
{
	$nom = htmlspecialchars($_POST['nom']);
	$prenom = htmlspecialschars($_POST['prenom']);
	$username = htmlspecialchars($_POST['username']);
	$pass_hache = password_hash($_POST['pass'], PASSWORD_DEFAULT);
	$reponse = htmlspecialchars($_POST['reponse']);
}

	if(!empty($_POST['nom']) AND !empty($_POST['prenom']) AND !empty($_POST['username']) AND !empty($_POST['pass']) AND !empty($_POST['question']) AND !empty($_POST['reponse']))

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
							<td>
								<label for ="Nom">Votre nom :</label>
							</td>
							<td>
								<input type="texte" placeholder="nom" id="nom" name="nom" />
							</td>
						</tr><br />
							<tr>
								<td>
									<label for ="Prenom">Votre prenom :</label>
								</td>
								<td>
									<input type="texte" placeholder="prenom" id="prenom" name="prenom" />
								</td>
							</tr><br />
						<tr>
							<td>
								<label for ="username">Votre pseudo :</label>
							</td>
							<td>
								<input type="texte" placeholder="username" id="username" name="username" />
							</td>
						</tr><br />
							<tr>
							<td>
								<label for ="pass">Votre mot de passe :</label>
							</td>
							<td>
								<input type="password" placeholder="mot de passe" id="pass" name="pass" />
							</td>
						</tr><br />
							<tr>
								<td>
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
								<td>
									<label for ="reponse">réponse à la question secrète :</label>
								</td>
								<td>
									<input type="texte" placeholder="reponse" id="reponse" name="reponse" />
								</td>
							<tr>
								<td></td>
								<td>
									<input type="submit" name="vinscription" value="valider l'inscription" />
								</td>
						</tr><br />
					</table>
			</div>
		</body>
			<footer>

			</footer>
</html>