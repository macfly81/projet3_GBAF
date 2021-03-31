<?php
session_start();

$bdd = new PDO('mysql:host=localhost;dbname=projet3_gbaf','root','root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

	

	if(isset($_GET['id_acteur']) AND isset($_SESSION['id_user']) AND isset($_SESSION['id_acteur']))
		{	 					
			$get_acteur = htmlspecialchars(($_GET['id_acteur']));
			$reqacteur = $bdd->prepare('SELECT * FROM acteurs WHERE id_acteur = ?');
			$reqacteur->execute(array(
				'id_acteur'=> $_GET['id_acteur'],
				'acteur' => $_SESSION['acteur'],
				'description' => $_SESSION['description'],
				'logo' => $_SESSION['logo']));
			$acteur= $reqacteur->fetch();	
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
				<h2>  </h2>
			<section class="conteneur acteurs">
					<table border= 1 class="tableau_acteur">
						<tr>
							<th>Numero Acteur</th>
							<th>Acteur</th>
							<th>Description</th>
							<th>Logo</th>
						</tr>
						<tr>
							<td align = "center"><?= $_GET['id_acteur']; ?></td>
							<td><?= $_SESSION['acteur']; ?></td>
							<td style="width:400px";><?= $_SESSION['description']; ?></td>
							<td> <img style="max-width:200px"; src ="<?= $_SESSION['logo']; ?>" /> </td>
						</tr>
				</table>
			</section>
			</div>
			<div><br />
				<h2> </h2>
			</body>
</html>