<?php
	use function
		LabSupervisor\functions\mainHeader,
		LabSupervisor\functions\lang;

	// Import header
	mainHeader(lang("REGISTER_TITLE"), true);

	// Logic
	echo '<script src="/public/js/function/popup.js"></script>';
	require($_SERVER["DOCUMENT_ROOT"] . '/logic/register.php');

	$identifiant = "";
	$name = "";
	$surname = "";
	$password = "";
	$passwordConfirm = "";
	if (isset($_POST["email"])) {
		$identifiant = $_POST["email"];
		$name = $_POST["name"];
		$surname = $_POST["surname"];
		$password = $_POST["password"];
		$passwordConfirm = $_POST["confpass"];
	}
?>

<link rel="stylesheet" href="/public/css/form.css">

<form class="mainbox mainform" method="post" onsubmit="loading()">
	<div>
		<h2><i class="ri-user-line"></i> <?= lang("REGISTER_TITLE") ?></h2>
	</div>
	<div>
		<input type="email" autocomplete="username" name="email" placeholder="<?= lang("REGISTER_EMAIL") ?>" value="<?= $identifiant ?>" required autofocus>
	</div>
	<div>
		<input type="password" autocomplete="new-password" id="password" name="password" placeholder="<?= lang("REGISTER_PASSWORD") ?>" value="<?= $password ?>" required>
		<button class="showPasswordButton" tabindex="-1" type="button" onclick="togglePasswordVisibility('password', 'eyeIcon')"><i id="eyeIcon" class="ri-eye-off-line"></i></button>
	</div>
	<div>
		<input type="password" autocomplete="new-password" id="passwordConf" name="confpass" placeholder="<?= lang("REGISTER_PASSWORD_CONFIRM") ?>" value="<?= $passwordConfirm ?>" required>
		<button class="showPasswordButton" tabindex="-1" type="button" onclick="togglePasswordVisibility('passwordConf', 'eyeIconConf')"><i id="eyeIconConf" class="ri-eye-off-line"></i></button>
	</div>
	<div>
		<input type="text" autocomplete="given-name" name="name" placeholder="<?= lang("MAIN_NAME") ?>" class="Name" value="<?= $name ?>" required>
	</div>
	<div>
		<input type="text" autocomplete="family-name" name="surname" placeholder="<?= lang("MAIN_SURNAME") ?>" value="<?= $surname ?>" required>
	</div>
	<div>
		<button class="button" type="submit" name="register"><i class="ri-id-card-line"></i> <?= lang("REGISTER_SUBMIT") ?></button>
	</div>
	<div>
		<a href="/login" class="link"><?= lang("REGISTER_ALREADYSIGN") ?></a>
	</div>
</form>

<script src="/public/js/registerPassword.js"></script>
<script src="/public/js/function/loading.js"></script>

<?php
	require($_SERVER["DOCUMENT_ROOT"] . '/include/footer.php');
?>
