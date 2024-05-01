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

<link rel="stylesheet" href="/public/css/form.css">

<form class="mainbox mainform" action="login" method="post">
	<div>
		<h2><i class="ri-user-line"></i> <?= lang("LOGIN_TITLE") ?></h2>
	</div>
	<div>
		<input type="text" id="username" name="email" placeholder="<?= lang("LOGIN_EMAIL") ?>" required autofocus>
	</div>
	<div>
		<input type="password" id="password" name="password" placeholder="<?= lang("LOGIN_PASSWORD") ?>" required>
		<button class="showPasswordButton" tabindex="-1" type="button" id="showPasswordButton" class="ShowPasswordButton" onclick="togglePasswordVisibility()"><i id="eyeIcon" class="ri-eye-off-line"></i></button>
	</div>
	<div>
		<button class="button" type="submit" name="login"><i class="ri-lock-unlock-line"></i> <?= lang("LOGIN_SUBMIT") ?></button>
	</div>

	<?php if ($_ENV["AUTHENTIFICATION_TYPE"] == "native") { ?>
	<div>
		<a class="link" href="/register"><?= lang("LOGIN_NOTSIGN") ?></a>
	</div>
	<?php } ?>
</form>

<script src="/public/js/loginPassword.js"></script>

<?php
	require($_SERVER["DOCUMENT_ROOT"] . '/include/footer.php');
?>
