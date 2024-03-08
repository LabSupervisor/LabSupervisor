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

<div class="AccountDiv">
	<h2><?= lang("ACCOUNT_TITLE") ?></h2>
	<form action="" method="post">
		<div class="form-group">
			<label for="new_name"><?= lang("ACCOUNT_NAME") ?></label>
			<input type="text" class="newname" name="new_name" value="<?php echo $user['name']; ?>">
		</div>
		<div class="form-group">
			<label for="new_surname"><?= lang("ACCOUNT_SURNAME") ?></label>
			<input type="text" class="newsurname" name="new_surname" value="<?php echo $user['surname']; ?>">
		</div>
		<div class="form-group">
			<label for="birthdate"><?= lang("ACCOUNT_BIRTHDATE") ?></label>
			<input type="date" class="newbirthDate" name="new_birthDate" value="<?php echo $user['birthdate']; ?>">
		</div>
		<div class="form-group">
			<label for="new_password"><?= lang("ACCOUNT_PASSWORD") ?></label>
			<input type="password" id="password" class="newpassword" name="new_password" aria-autocomplete="list">
			<button type="button" class="ShowPasswordButton" onclick="togglePasswordVisibility('password', 'eyeIcon')">
				<i id="eyeIcon" class="ri-eye-off-line"></i>
			</button>
		</div>
		<div class="form-group">
			<label for="conf_password"><?= lang("ACCOUNT_PASSWORD_CONFIRM") ?></label>
			<input type="password" id="passwordConf" class="confpassword" name="conf_password">
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
