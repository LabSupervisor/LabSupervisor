<?php
	use function
		LabSupervisor\functions\mainHeader,
		LabSupervisor\functions\lang,
		LabSupervisor\functions\permissionChecker;

	// Import header
	mainHeader(lang("NAVBAR_CONNECT"), true);

	// Ask for permissions
	permissionChecker(false, "");

	// Logic
	echo '<script src="/public/js/ft_popup.js"></script>';
	require($_SERVER["DOCUMENT_ROOT"] . '/logic/login.php');
?>

<link rel="stylesheet" href="/public/css/login.css">

<div class="mainbox LoginDiv">
	<form action="login" method="post">
		<h2><i class="ri-user-line"></i> <?= lang("LOGIN_TITLE") ?></h2>
		<input type="text" id="username" name="email" class="Username" placeholder="<?= lang("LOGIN_EMAIL") ?>" required autofocus><br>
		<div class="PasswordContainer">
			<input type="password" id="password" name="password" placeholder="<?= lang("LOGIN_PASSWORD") ?>" class="Password" required><br>
			<button tabindex="-1" type="button" id="showPasswordButton" class="ShowPasswordButton" onclick="togglePasswordVisibility()">
				<i id="eyeIcon" class="ri-eye-off-line"></i>
			</button>
		</div>
		<input type="submit" name="login" value="<?= lang("LOGIN_SUBMIT") ?>" class="button">
		<?php if ($_ENV["AUTHENTIFICATION_TYPE"] == "native") { ?>
			<a href="/register" class="register-link"><?= lang("LOGIN_NOTSIGN") ?></a>
		<?php } ?>
	</form>
</div>

<script src="/public/js/loginPassword.js"></script>

<?php
	require($_SERVER["DOCUMENT_ROOT"] . '/include/footer.php');
?>
