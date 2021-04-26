<?php
session_start();

$bdd = new PDO('mysql:host=localhost;dbname=projet3_gbaf','root','root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)); /*connexion à la bdd*/
 
 if(isset($_SESSION['id_user']))
 {



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
<html lang="fr">
	<head>
		<link rel="stylesheet" href="style.css" type="text/css" />
		<meta charset="utf-8"/>
		<meta name=viewport content="width=device-width, initial-scale=1">
		<link rel="icon" href="images/favicon_gbaf.ico" />
		<title>Groupement Banque Assurance Français</title>
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
		<div id="main">
			<p>Le Groupement Banque Assurance Français​ (GBAF) est une fédération représentant les 6 grands groupes français :</p>
				<ul>
					<li>BNP Paribas</li>
					<li>BPCE</li>
					<li>Crédit Agricole</li>
					<li>Crédit Mutuel-CIC</li>
					<li>Société Générale</li>
					<li>La Banque Postale</li>
				</ul> 

			<p>s’il existe une forte concurrence entre ces entités, elles vont toutes travailler de la même façon pour gérer près de 80 millions de comptes sur le territoire national.Le GBAF est le représentant de la profession bancaire et des assureurs sur tous les axes de la réglementation financière française. Sa mission est de promouvoir l'activité bancaire à l’échelle nationale. C’est aussi un interlocuteur privilégié des pouvoirs publics.</p>
			<div class="miseenpage">
				<h2> Liste des Acteurs et Partenaires </h2>
					<table class="tableau_acteur">
					<?php 	
					  	
						foreach($acteurs as $acteur):
					?>
						<tr>
							<td class="tdcenter"> <img style="max-width:200px" alt="logo" src ="<?= $acteur['logo']; ?>" /> </td>
							<td class="colonne_desc"><p><?= $acteur['description']; ?></p></td>
							<td class="tdcenter"> <a href="acteur.php?id_acteur=<?= $acteur['id_acteur']; ?>">lire la suite</a></td>
						</tr>
						 <?php endforeach ?>
				</table>
					<footer>
						| Mentions Légales | | Contact |
					</footer>
			</div>
			</div>
		</body>
</html>
<?php

}
else
{
 header("Location:index.php") ; 
}
?>
