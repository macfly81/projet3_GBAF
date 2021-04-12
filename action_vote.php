<?php
session_start();

$bdd = new PDO('mysql:host=localhost;dbname=projet3_gbaf','root','root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

if(isset($_GET['id_acteur']) AND isset($_SESSION['id_user']))
		{
			$id_user = $_SESSION['id_user'];
			$id_acteur = $_GET['id_acteur'];
			$gett = $_GET['t'];
			$jointure = "
			SELECT 'account.id_user', 'post.id_user' 
			FROM account
			LEFT JOIN vote 
			ON 'account.id_user' = 'vote.id_user'";
			$reqjointure = $bdd->prepare($jointure);
			$reqjointure->execute();
			$resultat = $reqjointure->fetchall();

			if(isset($_GET['t']) AND isset($_GET['id_acteur']) AND !empty($_GET['id_acteur']) AND !empty($_GET['t']))
				if($_GET['t'] == 1)

					{
						$checkdislike = $bdd->prepare('SELECT * FROM vote WHERE id_user = ? AND id_acteur = ? AND vote = 2');
						$checkdislike->execute(array($id_user, $id_acteur));
						if($checkdislike->rowCount() == 1)
						{
							$deletedislike = $bdd->prepare('DELETE vote FROM vote WHERE id_user = ? AND id_acteur = ? AND vote = 2');
							$deletedislike->execute(array($id_user, $id_acteur));
							header("Location: ".$_SERVER['HTTP_REFERER']."");
						}
						{
							$checklike = $bdd->prepare('SELECT * FROM vote WHERE id_user = ? AND id_acteur = ? AND vote = 1');
							$checklike->execute(array($id_user, $id_acteur));
								if($checklike->rowCount() == 1)
								{
									$deletelike = $bdd->prepare('DELETE vote FROM vote WHERE id_user = ? AND id_acteur = ? AND vote = 1');
									$deletelike->execute(array($id_user, $id_acteur));
									header("Location: ".$_SERVER['HTTP_REFERER']."");
								} else 
									{
										$likes = intval($_GET['t']);
										$insertlikes = $bdd->prepare("INSERT INTO vote(id_user, id_acteur, vote) VALUES($id_user, $id_acteur, ?)");
										$insertlikes->execute(array($likes));
										header("Location: ".$_SERVER['HTTP_REFERER']."");

									}
							}
						}
				elseif ($_GET['t'] == 2)
				 	{
							$checklike = $bdd->prepare('SELECT * FROM vote WHERE id_user = ? AND id_acteur = ? AND vote = 1');
							$checklike->execute(array($id_user, $id_acteur));
								if($checklike->rowCount() == 1)
								{
									$deletelike = $bdd->prepare('DELETE vote FROM vote WHERE id_user = ? AND id_acteur = ? AND vote = 1');
									$deletelike->execute(array($id_user, $id_acteur));
									header("Location: ".$_SERVER['HTTP_REFERER']."");
								}
						{
							$checkdislike = $bdd->prepare('SELECT * FROM vote WHERE id_user = ? AND id_acteur = ? AND vote = 2');
							$checkdislike->execute(array($id_user, $id_acteur));
								if($checkdislike->rowCount() == 1)
								{
									$deletedislike = $bdd->prepare('DELETE vote FROM vote WHERE id_user = ? AND id_acteur = ? AND vote = 2');
									$deletedislike->execute(array($id_user, $id_acteur));
									header("Location: ".$_SERVER['HTTP_REFERER']."");
								} else 
									{
										$dislikes = intval($_GET['t']);
										$insertdislikes = $bdd->prepare("INSERT INTO vote(id_user, id_acteur, vote) VALUES($id_user, $id_acteur, ?)");
										$insertdislikes->execute(array($dislikes));
										header("Location: ".$_SERVER['HTTP_REFERER']."");

									}
							
						}
					
				}		
		}		
?>