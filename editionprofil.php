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
			if($newnom != $_SESSION['nom'] OR ($newprenom != $_SESSION['prenom']) OR ($newusername != $_SESSION['username'])  OR $newreponse != $_SESSION['reponse'])
			{
				$updateuser = $bdd->prepare("UPDATE account SET `nom` = ?, `prenom`= ?, `username` = ?, `reponse` = ? WHERE id_user = ?");
				$updateuser->execute(array($newnom, $newprenom, $newusername, $newreponse, $profilexist['id_user']));

				header("Location: ".$_SERVER['HTTP_REFERER']."");

				$newnom = $_SESSION['nom'];
				$newprenom = $_SESSION['prenom'];
				$newusername = $_SESSION['username'];
				$newreponse = $_SESSION['reponse'];

			}
		}
	}
}	

?>

<!DOCTYPE html>
<html>
		<head>
		<link rel="stylesheet" href="style.css" type="text/css" />
		<meta charset="utf-8"/>
		<link rel="icon" href="images/favicon_gbaf.ico" />
		<title>Paramètre de votre compte </title>
		<div >
		<figure class="entete">
				<img style="max-width:80px"; src="images/logo_gbaf.png" alt="logo de gbaf" />
				<img src="images/contact.png" alt="image de contact" align="right" />
		<div align ="right">
				<p> Bienvenue<strong> <?php echo $_SESSION['prenom'] ?></strong></p>
				<?php 
					if(isset($_SESSION['id_user']))
					{
						?>
						<a href="deconnexion.php">Vous déconnecter</a>
						<?php
					}
				?>
		</figure>

		</div>
	</head>
		<body>
			<div align="center">
				<h2> Paramètres de votre compte</h2>
				<form method="POST" action="">
					<table>
						<tr>
							<td align="right">
								<label for ="Nom">Modifiez votre nom :</label>
							</td>
							<td>
								<input type="texte" placeholder="nom" id="newnom" name="newnom" value="<?php echo $_SESSION['nom']?>" />
							</td>
						</tr><br />
							<tr>
								<td align="right">
									<label for ="Prenom">Modifiez votre prenom :</label>
								</td>
								<td>
									<input type="texte" placeholder="prenom" id="newprenom" name="newprenom" value="<?php echo $_SESSION['prenom']?>" />
								</td>
							</tr><br />
						<tr>
							<td align="right">
								<label for ="username">Modifiez votre pseudo :</label>
							</td>
							<td>
								<input type="texte" placeholder="username" id="newusername" name="newusername" value="<?php echo $_SESSION['username']?>" />
							</td>
						</tr><br />				
							<tr>
								<td align="right">
									<label for ="reponse">Modifiez votre reponse secrète :</label>
								</td>
								<td>
									<input type="texte" placeholder="reponse" id="newreponse" name="newreponse" value="<?php echo $_SESSION['reponse']?>" />
								</td>
							</tr>
							<tr>
							<td align="right">
								<label for ="password">Validez votre mot de passe :</label>
							</td>
							<td>
								<input type="password" placeholder="mot de passe" id="newpassword" name="newpassword" />
							</td>
						</tr><br />
							<tr>
								<td></td>
								<td><br />
									<input type="submit" name="vmodification" value="validation des modifications" />
								</td>
						</tr><br /><br /> 
					</table> <br/><a href="connexion.php">Retourner à la page de connexion</a> 
							<br /><a href="profil.php">Retourner au profil</a>
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
				<div align="center">
					<p>| Mentions Légales |</p>
					<p>| Contact |</p>
				</div>
			</footer>
</html>