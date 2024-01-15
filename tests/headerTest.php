
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>header</title>
    <link rel="stylesheet" href="../public/css/main.css">
	<link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">
	<link rel="icon" href="../public/img/logo.ico" />

</head>

<body>


<h1>LabSupervisor</h1>


<?php session_start(); ?>


<nav class='navbar'>

    <a class="titre" href='accueil.php'> <i class="ri-home-line"></i> Accueil</a>

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

			<a class="titre" href='.php'><i class="ri-folder-line"> </i> Classe   </a>
			<a class="titre" href='.php'><i class="ri-computer-line"> </i> Créer Session </a>

			<a class="titre" href='.php'><i class="ri-user-line"> </i> Profil </a>

			<a class="titre" onclick='Deconnexion()' > Deconnection </a>




		<?php
		}

		//participant
		else if($role == "student"){
		?>

			<!-- <div class="navbar">
				<a href="#">Classe</a>
				<a href="#">Voir Session</a>
				<a href="#">Profil<span class="titre" onclick='Deconnexion()'>Déconnexion</span></a>
			</div> -->

			<a class="titre" href='.php'><i class="ri-folder-line"> </i> Classe </a>
			<a class="titre" href='.php'><i class="ri-computer-line"></i>Voir Session </a>
			<a class="titre" href='.php'><i class="ri-user-line"></i> Profil </a>
			<a class="titre" onclick='Deconnexion()' > Deconnection </a>


		<?php
		}

		//admin
		else if ($role == "admin"){
		?>

		<a class="titre" href='.php'> <i class="ri-user-line"></i> Profil </a>
		<a class="titre" onclick='Deconnexion()' > Deconnection </a>


		<?php
		}
		?>

	<?php
	}
	?>


</nav>





</body>
</html>
