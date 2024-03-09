<?php
	// Import header
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_header.php");
	mainHeader("Création de compte");

	// Ask for permissions
	permissionChecker(false, "");

	// Logic
	require($_SERVER["DOCUMENT_ROOT"] . '/logic/register.php');
?>

<link rel="stylesheet" href="/public/css/register.css">

<div class="mainbox RegisterDiv">
	<form action="register" method="post">
		<h2><i class="ri-user-line"></i> <?= lang("REGISTER_TITLE") ?></h2>
		<input type="email" name="email" placeholder="<?= lang("REGISTER_EMAIL") ?>" class="Email" required autofocus><br>
		<div class="PasswordContainer">
			<input type="password" id="password" name="password" placeholder="<?= lang("REGISTER_PASSWORD") ?>" class="Password" required><br>
			<button type="button" id="showPasswordButton" class="ShowPasswordButton" onclick="togglePasswordVisibility('password', 'eyeIcon')">
				<i id="eyeIcon" class="ri-eye-off-line"></i>
			</button>
		</div>
		<div class="PasswordContainer">
			<input type="password" id="passwordConf" name="confpass" placeholder="<?= lang("REGISTER_PASSWORD_CONFIRM") ?>" class="Password" required><br>
			<button type="button" id="showPasswordButton" class="ShowPasswordButton" onclick="togglePasswordVisibility('passwordConf', 'eyeIconConf')">
				<i id="eyeIconConf" class="ri-eye-off-line"></i>
			</button>
		</div>
		<input type="text" name="name" placeholder="<?= lang("REGISTER_NAME") ?>" class="Name" required><br>
		<input type="text" name="surname" placeholder="<?= lang("REGISTER_SURNAME") ?>" class="Surname" required><br>
		<input type="submit" name="register" value="<?= lang("REGISTER_SUBMIT") ?>" class="button">
		<a href="/login" class="login-link"><?= lang("REGISTER_ALREADYSIGN") ?></a>
	</form>
</div>

<script>
	// Password Hide/Show script
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
