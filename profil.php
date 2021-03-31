<?php
session_start();

$bdd = new PDO('mysql:host=localhost;dbname=projet3_gbaf','root','root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)); /*connexion à la bdd*/
 
	$reqacteurs = $bdd->prepare('SELECT *  FROM acteurs');
	$reqacteurs->execute();
	$acteurs = $reqacteurs->fetchAll();

	if(isset($_GET['id_acteur']) AND isset($_SESSION['id_user']))
		{						
				$_SESSION['id_acteur'] = $acteurs['id_acteur'];	
				$_SESSION['acteur'] = $acteurs['acteur'];
				$_SESSION['description'] = $acteurs['description'];
				$_SESSION['logo'] = $acteurs['logo'];
				header("acteur.php?");
		}
	
		
?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="style.css" type="text/css" />
		<meta charset="utf-8"/>
		<link rel="icon" href="images/favicon_gbaf.ico" />
		<title>Groupement Banque Assurance Français</title>
		<div >
		<figure>
				<img style="max-width:80px"; src="images/logo_gbaf.png" alt="logo de gbaf" />
				<img src="images/contact.png" alt="image de contact" align="right" />
		<div align ="right">
				<p> Bienvenue<strong> <?php echo $_SESSION['prenom'] ?></strong></p>
				<?php 
					if(isset($_SESSION['id_user']))
					{
						?>
						<a href="editonprofil.php">Changez votre mot de passe</a> <br />
						<a href="deconnexion.php">Vous déconnecter</a>
						<?php
					}
				?>
		</figure>

			
		</div>
	</head>
		<body>
			
			<div align="center">
				<h2> Liste des Acteurs et Partenaires </h2>
			<section class="conteneur acteurs">
					<table border= 1 class="tableau_acteur">
						<tr>
							<th>Numero Acteur</th>
							<th>Acteur</th>
							<th>Description</th>
							<th>Logo</th>
							<th>Acces page acteur</th>
						</tr>
					<?php 	
					  	
						foreach($acteurs as $acteur):
					?>

						<tr>
							<td align = "center"><?= $acteur['id_acteur']; ?></td>
							<td><?= $acteur['acteur']; ?></td>
							<td style="width:400px";><?= $acteur['description']; ?></td>
							<td> <img style="max-width:200px"; src ="<?= $acteur['logo']; ?>" /> </td>
							<td> <a href=acteur.php?id_acteur=<?= $acteur['id_acteur']; ?>>lire la suite</a></td>
						</tr>
						 <?php endforeach ?>
				</table>
			</section>
			</div>
		</body>
			<footer align="center">
				
			</footer>
</html>

