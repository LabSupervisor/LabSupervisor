<?php
	// Import header
	require($_SERVER["DOCUMENT_ROOT"] . "/function/ft_header.php");
	mainHeader(lang("NAVBAR_PROFIL_ACCOUNT"));

	// Ask for permissions
	permissionChecker(true, array(ADMIN, STUDENT, TEACHER));

	// Logic
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/updateUser.php");
	require($_SERVER["DOCUMENT_ROOT"] . "/function/ft_langFormat.php");

	// Delete account if ask for
	if (isset($_POST["confirm_delete"])) {
		UserRepository::delete($_SESSION["login"]);
		header("Location: /");
	}

	$user = UserRepository::getInfo($_SESSION["login"]);
?>

<link rel="stylesheet" href="/public/css/account.css">

<div id="updateCase" class="mainbox AccountDiv">
	<form method="post">
		<h2><i class="ri-user-line"></i> <?= lang("ACCOUNT_TITLE") ?></h2>

		<input type="text" placeholder="<?= lang("ACCOUNT_NAME") ?>" class="newname" name="new_name" value="<?php echo $user['name']; ?>" required>

		<input type="text" placeholder="<?= lang("ACCOUNT_SURNAME") ?>" class="newsurname" name="new_surname" value="<?php echo $user['surname']; ?>" required>

		<select class="lang" name="lang">
			<?php
				$userLang = UserRepository::getSetting($_SESSION["login"])["lang"];

				$langList = scandir($_SERVER["DOCUMENT_ROOT"] . "/lang/");
				$temp = array(".", "..");
				$langList = array_diff($langList, $temp);

				foreach($langList as $lang) {
					$lang = str_replace(".json", "", $lang);
					if ($lang == $userLang) {
						echo "<option selected='selected' value='" . $lang . "'>" . langFormat($lang) . "</option>";
					} else {
						echo "<option value='" . $lang . "'>" . langFormat($lang) . "</option>";
					}
				}
			?>
		</select>

		<div class="PasswordContainer">
			<input type="password" placeholder="<?= lang("ACCOUNT_PASSWORD") ?>" id="password" class="newpassword" name="new_password" aria-autocomplete="list">
			<button tabindex="-1" type="button" class="ShowPasswordButton" onclick="togglePasswordVisibility('password', 'eyeIcon')">
				<i id="eyeIcon" class="ri-eye-off-line"></i>
			</button>
		</div>

		<div class="PasswordContainer">
			<input type="password" placeholder="<?= lang("ACCOUNT_PASSWORD_CONFIRM") ?>" id="passwordConf" class="confpassword" name="conf_password">
			<button tabindex="-1" type="button" class="ShowPasswordButton" onclick="togglePasswordVisibility('passwordConf', 'eyeIconConf')">
				<i id="eyeIconConf" class="ri-eye-off-line"></i>
			</button>
		</div>

		<input type="submit" class="button" value="<?= lang("ACCOUNT_SUBMIT") ?>">
	</form>
	<button class="button" id="showDeleteForm"><?= lang("ACCOUNT_DELETE") ?></button>
</div>

<div id="confirmationForm" class="mainbox AccountDiv confirmDelete"  style="display: none;">
	<form method="post">
		<h2><i class="ri-error-warning-line"></i> <?= lang("ACCOUNT_DELETE_TITLE") ?></h2>
		<div class="deleteText">
			<a><?= lang("ACCOUNT_DELETE_DESCRIPTION") ?></a>
		</div>

		<label class="checkboxContainer"><?= lang("ACCOUNT_DELETE_YES") ?>
			<input class="checkbox" type="checkbox" id="deleteConfirm" name="deleteConfirm" required />
			<span class="checkmark"></span>
		</label>

		<br>
		<button class="button deleteCaseButton" type="button" id="cancel"> <?= lang("ACCOUNT_DELETE_CANCEL") ?></button>
		<input class="button deleteCaseButton" type="submit" name="confirm_delete" value="<?= lang("ACCOUNT_DELETE") ?>">
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

	// Change div display
	document.getElementById('showDeleteForm').addEventListener('click', function(event) {
		document.getElementById('confirmationForm').style.display = 'block';
		document.getElementById('updateCase').style.display = 'none';
	});

	document.getElementById('cancel').addEventListener('click', function() {
		document.getElementById('confirmationForm').style.display = 'none';
		document.getElementById('updateCase').style.display = 'block';
	});
</script>

<?php
	require($_SERVER["DOCUMENT_ROOT"] . '/include/footer.php');
?>
