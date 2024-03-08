<?php
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_header.php");
	mainHeader("Compte");

	permissionChecker(true, true, true, true);

	// Logic
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/updateUser.php");
?>

<?php
	$user = UserRepository::getInfo($_SESSION["login"]);
?>

<link rel="stylesheet" href="../public/css/account.css">

<div class="AccountDiv">
    <h2>Paramètres du compte</h2>
    <form action="" method="post">
        <div class="form-group">
            <label for="new_name">Nouveau nom:</label>
            <input type="text" class="newname" name="new_name" value="">
        </div>
        <div class="form-group">
            <label for="new_surname">Nouveau prénom:</label>
            <input type="text" class="newsurname" name="new_surname" value="">
        </div>
        <div class="form-group">
            <label for="birthdate">Nouvelle date de naissance:</label>
            <input type="date" class="newbirthDate" name="new_birthDate" value="">
        </div>
        <div class="form-group">
            <label for="new_password">Nouveau mot de passe:</label>
            <input type="password" class="newpassword" name="new_password" aria-autocomplete="list">
        </div>
        <div class="form-group">
            <label for="conf_password">Veuillez confirmer:</label>
            <input type="password" class="confpassword" name="conf_password">
        </div>
        <input type="submit" class="submit" value="Enregistrer les modifications">
    </form>
</div>
