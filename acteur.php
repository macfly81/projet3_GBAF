<?php
session_start();

$bdd = new PDO('mysql:host=localhost;dbname=projet3_gbaf','root','root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

	

	if(isset($_GET['id_acteur']) AND isset($_SESSION['id_user']) AND isset($_SESSION['id_acteur']))
		{	 					
			$get_acteur = htmlspecialchars(($_GET['id_acteur']));
			$reqacteur = $bdd->prepare('SELECT * FROM acteurs WHERE id_acteur = ?');
			$reqacteur->execute(array());
			
		}	
				
			
	
?>
<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="style.css" type="text/css" />
		<meta charset="utf-8"/>
		<link rel="icon" href="images/favicon_gbaf.ico" />
		<title></title>
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
							<td align = "center"><?= $acteur['id_acteur']; ?></td>
							<td><?= $acteur['acteur']; ?></td>
							<td style="width:400px";><?= $acteur['description']; ?></td>
							<td> <img style="max-width:200px"; src ="<?= $acteur['logo']; ?>" /> </td>
						</tr>
				</table>
			</section>
			</div>
			</body>
</html>