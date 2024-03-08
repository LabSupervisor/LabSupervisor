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
            <input type="text" class="newname" name="new_name" value="<?php echo $user['name']; ?>">
        </div>
        <div class="form-group">
            <label for="new_surname">Nouveau prénom:</label>
            <input type="text" class="newsurname" name="new_surname" value="<?php echo $user['surname']; ?>">
        </div>
        <div class="form-group">
            <label for="birthdate">Nouvelle date de naissance:</label>
            <input type="date" class="newbirthDate" name="new_birthDate" value="<?php echo $user['birthdate']; ?>">
        </div>
        <div class="form-group">
            <label for="new_password">Nouveau mot de passe:</label>
            <input type="password" id="password" class="newpassword" name="new_password" aria-autocomplete="list" required>
            <button type="button" class="ShowPasswordButton" onclick="togglePasswordVisibility('password', 'eyeIcon')">
                <i id="eyeIcon" class="ri-eye-off-line"></i>
            </button>
        </div>
        <div class="form-group">
            <label for="conf_password">Veuillez confirmer:</label>
            <input type="password" id="passwordConf" class="confpassword" name="conf_password" required>
            <button type="button" class="ShowPasswordButton" onclick="togglePasswordVisibility('passwordConf', 'eyeIconConf')">
                <i id="eyeIconConf" class="ri-eye-off-line"></i>
            </button>
        </div>
        <input type="submit" class="button" value="Enregistrer les modifications">
    </form>
</div>


<script> // Password Hide/Show script (same in login)
function togglePasswordVisibility(inputId, eyeIconId) {
    var passwordInput = document.getElementById(inputId);
    var eyeIcon = document.getElementById(eyeIconId);

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.className = 'ri-eye-line';
    } else {
        passwordInput.type = 'password';
        eyeIcon.className = 'ri-eye-off-line';
    }
}
</script>
