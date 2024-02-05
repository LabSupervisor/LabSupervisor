<?php
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_header.php");
	mainHeader("Création de compte");
?>

<?php
	if (isset($_SESSION["login"]))
		header("Location: /");
?>

<?php
	// Logic
	require($_SERVER["DOCUMENT_ROOT"] . '/logic/register.php');
?>

<h2>Création d'un utilisateur</h2>
<form action="" method="post">
	Email: <input type="email" name="email" required><br>
	Mot de passe: <input type="password" name="password" required><br>
	Confirmation de mot de passe: <input type="password" name="confpass" required><br>
	Prénom: <input type="text" name="name" required><br>
	Nom de Famille: <input type="text" name="surname" required><br>
	Date de naissance: <input type="date" name="birthdate" required><br>
	<input type="submit" name="register" value="Enregistrer">
</form>

<a href="<?="http://" . $_SERVER["SERVER_NAME"] . "/login.php"?>">
	<button>Déjà un compte ?</button>
</a>
