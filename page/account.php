<?php
	use LabSupervisor\app\repository\UserRepository;
	use function
		LabSupervisor\functions\mainHeader,
		LabSupervisor\functions\lang,
		LabSupervisor\functions\langFormat,
		LabSupervisor\functions\permissionChecker;

	// Import header
	mainHeader(lang("NAVBAR_PROFIL_ACCOUNT"), true);

	// Ask for permissions
	permissionChecker(true, array(ADMIN, STUDENT, TEACHER));

	// Logic
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/updateUser.php");

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
				$langList = array_diff($langList, array(".", "..", "index.php"));

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

		<button type="submit" class="button"><i class="ri-save-2-line"></i> <?= lang("ACCOUNT_SUBMIT") ?></button>
	</form>
	<button class="back" id="showDeleteForm"><i class="ri-delete-bin-line"></i> <?= lang("ACCOUNT_DELETE") ?></button>
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
		<button class="back deleteCaseButton" type="button" id="cancel"><i class="ri-arrow-left-line"></i> <?= lang("ACCOUNT_DELETE_CANCEL") ?></button>
		<button class="button deleteCaseButton" type="submit" name="confirm_delete"><i class="ri-delete-bin-line"></i> <?= lang("ACCOUNT_DELETE") ?></button>
	</form>
</div>

<script src="/public/js/accountPassword.js"></script>

<?php
	require($_SERVER["DOCUMENT_ROOT"] . '/include/footer.php');
?>
