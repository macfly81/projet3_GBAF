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
		</figure>

			
		</div>
	</head>
		<header style="background-color:#c0c0c0";>
			<h1 align="center">
				<p style="font-style: italic ;">Le Groupement Banque Assurance Français​ (GBAF) est une fédération représentant les 6 grands groupes français :</p>
					<ul>
						<li>BNP Paribas</li>
						<li>BPCE</li>
						<li>Crédit Agricole</li>
						<li>Crédit Mutuel-CIC</li>
						<li>Société Générale</li>
						<li>La Banque Postale</li>
					</ul> 

				<p style="font-style: italic ;">s’il existe une forte concurrence entre ces entités, elles vont toutes travailler de la même façon pour gérer près de 80 millions de comptes sur le territoire national.Le GBAF est le représentant de la profession bancaire et des assureurs sur tous les axes de la réglementation financière française. Sa mission est de promouvoir l'activité bancaire à l’échelle nationale. C’est aussi un interlocuteur privilégié des pouvoirs publics.</p>
			</h1>
		</header>
		<body>
			
			<div align="center">
				<h2> Liste des Acteurs et Partenaires </h2>
			<section class="conteneur acteurs">
					<table border= 1 class="tableau_acteur">
						<tr>
							<th>Logo</th>
							<th>Description</th>
							<th>En savoir plus</th>
						</tr>
					<?php 	
					  	
						foreach($acteurs as $acteur):
					?>

						<tr>
							<td align="center"> <img style="max-width:200px"; src ="<?= $acteur['logo']; ?>" /> </td>
							<td align="center"><p style="max-width: 20"><?= $acteur['description']; ?></p></td>
							<td align="center"> <a href="acteur.php?id_acteur=<?= $acteur['id_acteur']; ?>">lire la suite</a></td>
						</tr>
						 <?php endforeach ?>
				</table>
			</section>
			</div>
		</body>
			<footer style="background-color:#c0c0c0"; style="padding: 20px">
				<div align="center">
					<p>| Mentions Légales |</p>
					<p>| Contact |</p>
				</div>
			</footer>
</html>

