<?php

	use function
		LabSupervisor\functions\mainHeader,
		LabSupervisor\functions\lang;

	$identifiant = "";
	$password = "";
	if (isset($_POST["email"])) {
		$identifiant = $_POST["email"];
		$password = $_POST["password"];
	}

	// Import header
	mainHeader(lang("NAVBAR_CONNECT"), true);

	// Logic
	echo '<script src="/public/js/function/popup.js"></script>';
	require($_SERVER["DOCUMENT_ROOT"] . '/logic/login.php');
?>

<link rel="stylesheet" href="/public/css/form.css">

<form class="mainbox mainform" method="post" onsubmit="loading()">
	<div>
		<h2><i class="ri-user-line"></i> <?= lang("LOGIN_TITLE") ?></h2>
	</div>
	<div>
		<input type="text" autocomplete="username" id="username" name="email" placeholder="<?= lang("LOGIN_EMAIL") ?>" value="<?= $identifiant ?>" required autofocus>
	</div>
	<div>
		<input type="password" autocomplete="current-password" id="password" name="password" placeholder="<?= lang("LOGIN_PASSWORD") ?>" value="<?= $password ?>" required>
		<button class="showPasswordButton" tabindex="-1" type="button" id="showPasswordButton" onclick="togglePasswordVisibility()"><i id="eyeIcon" class="ri-eye-off-line"></i></button>
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
<script src="/public/js/function/loading.js"></script>

<?php
	require($_SERVER["DOCUMENT_ROOT"] . '/include/footer.php');
?>
