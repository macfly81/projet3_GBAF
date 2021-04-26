<?php
session_start();

$bdd = new PDO('mysql:host=localhost;dbname=projet3_gbaf','root','root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	
	if(isset($_SESSION['id_user']))


	{
			$id_user = $_SESSION['id_user'];
			$id_acteur = $_GET['id_acteur'];
			$likes = $bdd->prepare('SELECT id_acteur FROM vote WHERE id_acteur = ? AND vote = 1');
			$likes->execute(array($id_acteur));
			$likes = $likes->rowcount();

			$dislikes = $bdd->prepare('SELECT id_acteur FROM vote WHERE id_acteur = ? AND vote = 2');
			$dislikes->execute(array($id_acteur));
			$dislikes = $dislikes->rowcount();
	

	if(isset($_GET['id_acteur']) AND isset($_SESSION['id_user']))
		{	
			
			$get_acteur = htmlspecialchars(($_GET['id_acteur']));
			$reqacteur = $bdd->prepare('SELECT * FROM acteurs WHERE id_acteur = ?');
			$reqacteur->execute(array($_GET['id_acteur']));
			$acteur = $reqacteur->fetch();
		}
		$commentaires = $bdd->prepare("SELECT * FROM post WHERE id_acteur = ? ORDER BY post DESC");
		$commentaires->execute(array($get_acteur));

	if(isset($_GET['id_acteur']) AND isset($_SESSION['id_user']))
		{
			$prenom_user = $_SESSION["prenom"];
			$id_user = $_SESSION['id_user'];
			$id_acteur = $_GET['id_acteur'];
			$jointure = "
			SELECT 'account.id_user', 'post.id_user' 
			FROM account
			INNER JOIN post 
			ON 'account.id_user' = 'post.id_user'"; 
			$reqjointure = $bdd->prepare($jointure);
			$reqjointure->execute();
			$resultat = $reqjointure->fetchall();

			if(isset($_POST['submit_commentaire']) AND isset($_POST['commentaire']) AND !empty($_POST['commentaire']))
				{
					$commentaire = htmlspecialchars($_POST['commentaire']);
					$insertcomm = $bdd->prepare("INSERT INTO post(id_user, id_acteur, prenom, date_add, post) VALUES($id_user, $id_acteur, '".$prenom_user."', NOW(), ?)");
					$insertcomm->execute(array($commentaire));
					header("Location: ".$_SERVER['HTTP_REFERER']."");
				}
		}		
			
	
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<link rel="stylesheet" href="style.css" type="text/css" />
		<meta charset="utf-8"/>
		<meta name=viewport content="width=device-width, initial-scale=1">
		<link rel="icon" href="images/favicon_gbaf.ico" />
		<title>Page Acteur</title>
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
				<div class="miseenpage">
			<section >
					<img style="max-width:300px" alt="logo" src ="<?= $acteur['logo']; ?>" />
					<p> <?= $acteur['description']; ?> </p>
					<a href="profil.php?">Retour au profil</a>
			</section>
				</div>
			<div class="miseenpage"> <br />
				<a href="action_vote.php?t=1&id_acteur=<?= $_GET['id_acteur'] ?>"><img style="max-width:50px" src="images/like.png" alt="like" /></a> <span class="likes"><?= $likes ?></span>
				<a href="action_vote.php?t=2&id_acteur=<?= $_GET['id_acteur'] ?>"><img style="max-width:50px" src="images/dislike.png" alt="dislike" /></a> <span class="likes"><?= $dislikes ?></span>
			</div>
				<form  method="POST">
								<div class="miseenpage">
									<input type="submit" value="Nouveau commentaire" name="submit_commentaire" /><br/><br/>
								   <textarea rows="13" cols="60" name="commentaire" id="commentaire" placeholder="Votre commentaire..."></textarea>
								</div><br/>
							</form>
					<br /><br/>
			<div class="miseenpage"><br />
					<br />
					<div class="espace_commentaire"><?php
						while($c = $commentaires->fetch()) { ?>
						<b><?= $c['prenom']?> <br /> le : </b> <?= $c['date_add']?>  <br /><br /><b class="comm"> "<?= $c['post'] ?>" <br /><br /><br /></b>
					<?php } ?></div>
				</div>
					<footer>
						| Mentions Légales | | Contact |
					</footer>
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
