
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>header</title>
    <link rel="stylesheet" href="../public/css/main.css">
	<link rel="icon" href="../public/img/logo.ico" />

</head>

<body>


<h1>LabSupervisor</h1>

<?php session_start(); ?>


<nav class='menu'>

    <a class="titre" href='accueil.php'> Accueil </a>

    <?php $role = "teacher" ; ?>

	<!-- pas connecté -->
    <?php if ($role =="") { ?>

    <button onclick="Connexion()"> Connexion </button>

    <?php
    }

	//connecté
	else {

		//formateur
		if ($role == "teacher") {
		?>

			<a class="titre" href='.php'> Classe </a>
			<a class="titre" href='.php'> Créer Session </a>

			<a class="titre" href='.php'> Profil </a>

			<button onclick='Deconnexion()' > Deconnection </button>




		<?php
		}

		//participant
		else if($role == "student"){
		?>

			<a class="titre" href='.php'> Classe </a>
			<a class="titre" href='.php'> Voir Session </a>
			<a class="titre" href='.php'> Profil </a>

			<button onclick='Deconnexion()' > Deconnection </button>

		<?php
		}

		//admin
		else if ($role == "admin"){
		?>

		<a class="titre" href='.php'> Profil </a>
		<button onclick='Deconnexion()' > Deconnection </button>


		<?php
		}
		?>

	<?php
	}
	?>


</nav>





</body>
</html>
