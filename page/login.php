<?php
	// Import header
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_header.php");
	mainHeader("Connexion");

	// Ask for permissions
	permissionChecker(false, "");
?>

<?php
	// Logic
	require($_SERVER["DOCUMENT_ROOT"] . '/logic/login.php');
?>

<link rel="stylesheet" href="/public/css/login.css">

<div class="LoginDiv">
	<form action="login" method="post">
		<h2><?= lang("LOGIN_TITLE") ?></h2>
		<input type="text" id="username" name="email" class="Username" placeholder="<?= lang("LOGIN_EMAIL") ?>" required autofocus><br>
		<div class="PasswordContainer">
			<input type="password" id="password" name="password" placeholder="<?= lang("LOGIN_PASSWORD") ?>" class="Password" required><br>
			<button type="button" id="showPasswordButton" class="ShowPasswordButton" onclick="togglePasswordVisibility()">
				<i id="eyeIcon" class="ri-eye-off-line"></i>
			</button>
		</div>
		<div class="LoginDivButons">
			<input type="submit" name="login" value="<?= lang("LOGIN_SUBMIT") ?>" class="button">
			<a href="/register" class="register-link"><?= lang("LOGIN_NOTSIGN") ?></a>
		</div>
	</form>
</div>

<script>
// Password Hide/Show script (same in login)
function togglePasswordVisibility() {
	var passwordInput = document.getElementById('password');
	var eyeIcon = document.getElementById('eyeIcon');

	if (passwordInput.type === 'password') {
		passwordInput.type = 'text';
		eyeIcon.className = 'ri-eye-line';
	} else {
		passwordInput.type = 'password';
		eyeIcon.className = 'ri-eye-off-line';
	}
}
</script>
