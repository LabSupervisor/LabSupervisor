<?php
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_header.php");
	mainHeader("Compte");
?>

<?php
	permissionChecker(true, true, true, true);
?>

<?php
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/updateUser.php");
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_getUser.php");
?>

<?php
	$user = getUser($_SESSION["login"]);
?>

<h2>Paramètres du compte</h2>
<form action="" method="post">
	<label for="new_name">Nouveau nom:</label>
	<input type="text" name="new_name" value="<?php echo $user[0]['name']; ?>"><br>
	<label for="new_surname">Nouveau prénom:</label>
	<input type="text" name="new_surname" value="<?php echo $user[0]['surname']; ?>"><br>
	<label for="birthdate">Nouvelle date de naissance:</label>
	<input type="date" name="new_birthDate" value="<?php echo $user[0]['birthdate']; ?>" class="Birthdate"><br>
	<label for="new_password">Nouveau mot de passe:</label>
	<input type="password" name="new_password"><br>
	<label for="new_password">Veuillez confirmer:</label>
	<input type="password" name="conf_password"><br>
	<input type="submit" value="Enregistrer les modifications">
</form>
