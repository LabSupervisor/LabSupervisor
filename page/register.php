<?php
	use function
		LabSupervisor\functions\mainHeader,
		LabSupervisor\functions\lang,
		LabSupervisor\functions\permissionChecker;

	// Import header
	mainHeader(lang("REGISTER_TITLE"), true);

	// Ask for permissions
	permissionChecker(false, "");

	// Logic
	echo '<script src="/public/js/ft_popup.js"></script>';
	require($_SERVER["DOCUMENT_ROOT"] . '/logic/register.php');
?>

<link rel="stylesheet" href="/public/css/form.css">

<form class="mainbox mainform" action="register" method="post">
	<div>
		<h2><i class="ri-user-line"></i> <?= lang("REGISTER_TITLE") ?></h2>
	</div>
	<div>
		<input type="email" name="email" placeholder="<?= lang("REGISTER_EMAIL") ?>" required autofocus>
	</div>
	<div>
		<input type="password" id="password" name="password" placeholder="<?= lang("REGISTER_PASSWORD") ?>" required>
		<button class="showPasswordButton" tabindex="-1" type="button" id="showPasswordButton" onclick="togglePasswordVisibility('password', 'eyeIcon')"><i id="eyeIcon" class="ri-eye-off-line"></i></button>
	</div>
	<div>
		<input type="password" id="passwordConf" name="confpass" placeholder="<?= lang("REGISTER_PASSWORD_CONFIRM") ?>" required>
		<button class="showPasswordButton" tabindex="-1" type="button" id="showPasswordButton" onclick="togglePasswordVisibility('passwordConf', 'eyeIconConf')"><i id="eyeIconConf" class="ri-eye-off-line"></i></button>
	</div>
	<div>
		<input type="text" name="name" placeholder="<?= lang("REGISTER_NAME") ?>" class="Name" required>
	</div>
	<div>
		<input type="text" name="surname" placeholder="<?= lang("REGISTER_SURNAME") ?>" required>
	</div>
	<div>
		<button class="button" type="submit" name="register"><i class="ri-id-card-line"></i> <?= lang("REGISTER_SUBMIT") ?></button>
	</div>
	<div>
		<a href="/login" class="link"><?= lang("REGISTER_ALREADYSIGN") ?></a>
	</div>
</form>

<script src="/public/js/registerPassword.js"></script>

<?php
	require($_SERVER["DOCUMENT_ROOT"] . '/include/footer.php');
?>
