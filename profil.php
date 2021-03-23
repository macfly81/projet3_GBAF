<?php
session_start();
header("content-type : image/png");

$bdd = new PDO('mysql:host=localhost;dbname=projet3_gbaf','root','root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)); /*connexion à la bdd*/
if(isset($_GET['id_user']) AND $_GET['id_user'] > 0)
{
	$getid_user = intval($_GET['id_user']); /*dois-je rajouter le htmlspecialchars ici ?*/
	$reqprofil = $bdd->prepare('SELECT * FROM account WHERE id_user = ?');
	$reqprofil->execute(array($getid_user));
	$userinfo = $reqprofil->fetch();
		
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
				<img src="images/logo_gbaf.png" alt="logo de gbaf" />
				<img src="images/contact.png" alt="image de contact" align="right" />
		<div align ="right">
				<p> Bienvenue<strong> <?php echo $userinfo['nom'] .' '. $userinfo['prenom']; ?></strong></p>
				<?php 
					if(isset($_SESSION['id_user']) AND $userinfo['id_user'] == $_SESSION['id_user'])
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
				<table border= 1 align="center">
					<tr>
						<th>Logo</th>
						<th>Description</th>
					</tr>
					<tr>
						<td><img style="max-width: 150px;" src="images/cde.png"></td>
						<td><p>La CDE (Chambre Des Entrepreneurs) accompagne les entreprises dans leurs démarches de formation. 
	Son président est élu pour 3 ans par ses pairs,...<a href=#>Lire la suite</a></p></td>
					</tr>
					<tr>
						<td><img style="max-width: 150px;" src="images/Dsa_france.png"></td>
						<td><p>Dsa France accélère la croissance du territoire et s’engage avec les collectivités territoriales. Nous accompagnons les entreprises dans les étapes clés...<a href=#>Lire la suite</a></p></td>
					</tr>
					<tr>
						<td><img style="max-width: 150px;" src="images/protectpeople.png"></td>
						<td><p>Chez Protectpeople, chacun cotise selon ses moyens et reçoit selon ses besoins. Proectecpeople est ouvert à tous, sans considération d’âge ou d’état de santé. Nous garantissons un accès aux soins et...<a href=#>Lire la suite</a></p></td>
					</tr>
					<tr>
						<td><img style="max-width: 150px;" src="images/formationco.png"></td>
						<td><p>Formation&ampco est une association française présente sur tout le territoire. Nous proposons à des personnes issues de tout milieu de devenir entrepreneur grâce à un crédit et un accompagnement...<a href=#>Lire la suite</a></p></td>
					</tr>
				</table>
				

			</section>
					
			</div>
		</body>
			<footer>

			</footer>
</html>
<?php
}
?>