<?php
	// Import header
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_header.php");
	mainHeader("Compte");

	// Ask for permissions
	permissionChecker(true, array(admin, student, teacher));

	// Logic
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/updateUser.php");

	$user = UserRepository::getInfo($_SESSION["login"]);
?>

<link rel="stylesheet" href="/public/css/account.css">

<div class="mainbox AccountDiv">
	<form action="" method="post">
		<h2><i class="ri-user-line"></i> <?= lang("ACCOUNT_TITLE") ?></h2>
		<input type="text" placeholder="<?= lang("ACCOUNT_NAME") ?>" class="newname" name="new_name" value="<?php echo $user['name']; ?>" required>
		<input type="text" placeholder="<?= lang("ACCOUNT_SURNAME") ?>" class="newsurname" name="new_surname" value="<?php echo $user['surname']; ?>" required>
		<div class="PasswordContainer">
			<input type="password" placeholder="<?= lang("ACCOUNT_PASSWORD") ?>" id="password" class="newpassword" name="new_password" aria-autocomplete="list">
			<button type="button" class="ShowPasswordButton" onclick="togglePasswordVisibility('password', 'eyeIcon')">
				<i id="eyeIcon" class="ri-eye-off-line"></i>
			</button>
		</div>
		<div class="PasswordContainer">
			<input type="password" placeholder="<?= lang("ACCOUNT_PASSWORD_CONFIRM") ?>" id="passwordConf" class="confpassword" name="conf_password">
			<button type="button" class="ShowPasswordButton" onclick="togglePasswordVisibility('passwordConf', 'eyeIconConf')">
				<i id="eyeIconConf" class="ri-eye-off-line"></i>
			</button>
		</div>
		<input type="submit" class="button" value="<?= lang("ACCOUNT_SUBMIT") ?>">
	</form>
</div>

<script>
	// Password Hide/Show script (same in login)
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
