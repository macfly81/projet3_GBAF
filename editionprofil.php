<?php
session_start();

$bdd = new PDO('mysql:host=localhost;dbname=projet3_gbaf','root','root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

if(isset($_SESSION['username']))
	$reqprofil = $bdd->prepare('SELECT id_user, nom, prenom, password, reponse FROM account WHERE username = :username');
			$reqprofil->execute(array(
			'username' => $_SESSION['username']));
			$profilexist = $reqprofil->fetch();
	if(isset($_POST['vmodification']))
{
	$newnom = htmlspecialchars($_POST['newnom']);
	$newprenom = htmlspecialchars($_POST['newprenom']);
	$newusername = htmlspecialchars($_POST['newusername']);
	$newreponse = htmlspecialchars($_POST['newreponse']);
	$newpassword = password_hash($_POST['newpassword'], PASSWORD_DEFAULT);

if(!empty($_POST['newnom']) AND !empty($_POST['newprenom']) AND !empty($_POST['newusername']) AND !empty($_POST['newpassword']) AND !empty($_POST['newreponse']))
    {
	if(preg_match('/^[a-zA-ZáàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆ-]+$/', $_POST['newnom']) AND preg_match('/^[a-zA-ZáàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆ-]+$/', $_POST['newprenom']) AND preg_match('/^[a-zA-Z0-9-_]{2,36}$/', $_POST['newusername']))
		{
			if($newnom != $_SESSION['nom'] OR ($newprenom != $_SESSION['prenom']) OR ($newusername != $_SESSION['username'])  OR $newreponse != $_SESSION['reponse'] OR $newpassword != $_SESSION['password'])
			{
				$updateuser = $bdd->prepare("UPDATE account SET `nom` = ?, `prenom`= ?, `username` = ?, `reponse` = ?, `password` = ? WHERE id_user = ?");
				$updateuser->execute(array($newnom, $newprenom, $newusername, $newreponse, $newpassword, $profilexist['id_user']));


				$_SESSION['nom'] = $newnom ; 
				$_SESSION['prenom'] = $newprenom ;
				$_SESSION['username'] = $newusername ;
				$_SESSION['reponse'] = $newreponse ;
				header("Location:profil.php");

			}
		} else { $erreur = "votre pseudonyme doit contenir entre 2 et 36 caractères et être au format alphanumérique !" ;}
	} else { $erreur = "tous les champs doivent être remplis ! En saisissant votre mot de passe, les modifications prendront effet." ;}
}	

?>

<!DOCTYPE html>
<html lang="fr">
		<head>
		<link rel="stylesheet" href="style.css" type="text/css" />
		<meta charset="utf-8"/>
		<meta name=viewport content="width=device-width, initial-scale=1">
		<link rel="icon" href="images/favicon_gbaf.ico" />
		<title>Paramètres de votre compte</title>
	</head>
	<body>
		<header>
		<figure>
			<img style="max-width:80px" src="images/logo_gbaf.png" alt="logo de gbaf" />
		</figure>
		<div class="entete">
				<img src="images/contact.png" alt="image de contact"/>
				<p> Bienvenue<strong> <?php echo $_SESSION['prenom']. ' ' . $_SESSION['nom']?></strong></p>
				<?php 
					if(isset($_SESSION['id_user']))
					{
						?>
						<a href="editionprofil.php">Changez votre mot de passe</a> <br />
						<a href="deconnexion.php">Vous déconnecter</a>
						<?php
					} 
				?>
		</div>
		</header>
			<div class="miseenpage">
				<h2> Paramètres de votre compte</h2>
				<form method="POST">
					<table>
						<tr>
							<td >
								<label for ="newnom">Modifiez votre nom :</label>
							</td>
							<td>
								<input type="text" placeholder="nom" id="newnom" name="newnom" value="<?php echo $_SESSION['nom']?>" />
							</td>
						</tr>
							<tr>
								<td>
									<label for ="newprenom">Modifiez votre prenom :</label>
								</td>
								<td>
									<input type="text" placeholder="prenom" id="newprenom" name="newprenom" value="<?php echo $_SESSION['prenom']?>" />
								</td>
							</tr>
						<tr>
							<td>
								<label for ="newusername">Modifiez votre pseudo :</label>
							</td>
							<td>
								<input type="text" placeholder="username" id="newusername" name="newusername" value="<?php echo $_SESSION['username']?>" />
							</td>
						</tr>				
							<tr>
								<td>
									<label for ="newreponse">Modifiez votre reponse secrète :</label>
								</td>
								<td>
									<input type="text" placeholder="reponse" id="newreponse" name="newreponse" value="<?php echo $_SESSION['reponse']?>" />
								</td>
							</tr>
							<tr>
							<td>
								<label for ="newpassword">Validez votre mot de passe :</label>
							</td>
							<td>
								<input type="password" placeholder="mot de passe" id="newpassword" name="newpassword" />
							</td>
						</tr>
							<tr>
								<td></td>
								<td>
									<input type="submit" name="vmodification" value="validation des modifications" />
								</td>
						</tr> 
					</table> <br/><a href="index.php">Retourner à la page de connexion</a> 
							<br /><a href="profil.php">Retourner au profil</a>
				</form>
				<?php
					if(isset($erreur))
					{
						echo $erreur;
					}
				?>
			</div>
				<footer>
					| Mentions Légales | | Contact |
				</footer>
		</body>
</html>