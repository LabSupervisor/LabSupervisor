<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>header</title>
	<link rel="stylesheet" href="../public/css/main.css">
	<link rel="stylesheet" href="../public/css/navbar.css">
	<link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">
	<link rel="icon" href="../public/img/logo.ico" />
</head>

<body>

<?php session_start(); ?>

<nav class='navbar'>

	<!-- logo -->

	<div class="logo-container left">
		<?php
			// Chemin absolu vers l'image (ajustez le chemin selon votre structure de fichiers)
			$cheminImage = "http://" .$_SERVER['SERVER_NAME'] . '/public/img/logo.ico';

			// Afficher l'image du logo dans la balise img
			echo '<img src="' . $cheminImage . '" alt="Logo">';
		?>
	</div>

	<a class="titre left no-hover-color"> NOM DE LA PAGE </a>

	<!-- role -->
	<?php $role = "admin" ; ?>

	<!-- pas connecté -->
	<?php if ($role =="") { ?>

	<a class="titre" onclick='Connexion()' > Connection </a>

	<?php
	}

	//connecté
	else {

		//formateur
		if ($role == "teacher") {
		?>

		<ul>
			<li>
				<a class="titre" href='accueil.php'> <i class="ri-home-line"></i> Accueil</a>
			</li>
			<li>
				<a class="titre" href='#'><i class="ri-folder-line"></i> Classe </a>
			</li>
			<li>
				<a class="titre" href='.php'><i class="ri-computer-line"> </i> Créer Session </a>
			</li>
			<li class="deroulant"><a href='#'><i class="ri-user-line"></i> Profil </a>
				<ul class="sous">
				<li>
					<a href='.php'>  Déconnexion </a>
				</li>
				<li>
					<a href='.php'>  Déconnexion </a>
				</li>
				</ul>
			</li>
		</ul>

		<?php
		}

		//participant
		else if($role == "student"){
		?>

		<ul>
			<li>
				<a class="titre" href='accueil.php'> <i class="ri-home-line"></i> Accueil</a>
			</li>
			<li>
				<a class="titre" href='#'><i class="ri-folder-line"></i> Classe </a>
			</li>
			<li>
				<a class="titre" href='#'><i class="ri-computer-line"></i> Voir Session </a>
			</li>

			<li class="deroulant"><a href='#'><i class="ri-user-line"></i> Profil </a>
				<ul class="sous">
				<li>
					<a href='.php'>  Déconnexion </a>
				</li>
				<li>
					<a href='.php'>  Déconnexion </a>
				</li>
				</ul>
			</li>
		</ul>

		<?php
		}

		//admin
		else if ($role == "admin"){
		?>
		<ul>
			<li>
				<a class="titre" href='accueil.php'> <i class="ri-home-line"></i> Accueil</a>
			</li>
			<li>
				<a class="titre" href='#'><i class="ri-folder-line"></i> Classe </a>
			</li>
			<li class="deroulant">		<a class="titre" href='.php'><i class="ri-computer-line"> </i>  Session </a>
				<ul class="sous">
				<li>
					<a class="titre" href='.php'>Créer Session </a>
				</li>
				<li>
					<a class="titre" href='.php'>Voir Session </a>

				</li>
				</ul>
			</li>
			<li class="deroulant"><a href='#'><i class="ri-user-line"></i> Profil </a>
				<ul class="sous">
				<li>
					<a href='.php'>  Deconnexion </a>
				</li>
				<li>
					<a href='.php'>  Déconnexion </a>
				</li>
				</ul>
			</li>
		</ul>

		<?php
		}
		?>

	<?php
	}
	?>
</nav>
