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

<link rel="stylesheet" href="/public/css/form.css">
<link rel="stylesheet" href="/public/css/account.css">

<div class="mainbox mainform column" id="updateCase">
	<form method="post">
		<div>
			<h2><i class="ri-user-line"></i> <?= lang("ACCOUNT_TITLE") ?></h2>
		</div>
		<div>
			<input type="text" placeholder="<?= lang("ACCOUNT_NAME") ?>" name="new_name" value="<?php echo $user['name']; ?>" required>
		</div>
		<div>
			<input type="text" placeholder="<?= lang("ACCOUNT_SURNAME") ?>" name="new_surname" value="<?php echo $user['surname']; ?>" required>
		</div>
		<div>
			<select name="lang">
				<?php
					$userLang = UserRepository::getSetting($_SESSION["login"])["lang"];

					$langList = scandir($_SERVER["DOCUMENT_ROOT"] . "/public/lang/");
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
		</div>
		<div>
			<input type="password" placeholder="<?= lang("ACCOUNT_PASSWORD") ?>" id="password" name="new_password">
			<button class="showPasswordButton" tabindex="-1" type="button" onclick="togglePasswordVisibility('password', 'eyeIcon')"><i id="eyeIcon" class="ri-eye-off-line"></i></button>
		</div>

		<div>
			<input type="password" placeholder="<?= lang("ACCOUNT_PASSWORD_CONFIRM") ?>" id="passwordConf" name="conf_password">
			<button class="showPasswordButton" tabindex="-1" type="button" onclick="togglePasswordVisibility('passwordConf', 'eyeIconConf')"><i id="eyeIconConf" class="ri-eye-off-line"></i></button>
		</div>

		<div>
			<button class="button" type="submit"><i class="ri-save-2-line"></i> <?= lang("ACCOUNT_SUBMIT") ?></button>
		</div>
	</form>
	<button class="back" id="showDeleteForm" type=""><i class="ri-delete-bin-line"></i> <?= lang("ACCOUNT_DELETE") ?></button>
</div>

<form class="mainbox confirmDelete" id="confirmationForm" style="display: none;" method="post">
	<h2><i class="ri-error-warning-line"></i> <?= lang("ACCOUNT_DELETE_TITLE") ?></h2>
	<a><?= lang("ACCOUNT_DELETE_DESCRIPTION") ?></a>

	<label class="checkboxContainer"><?= lang("ACCOUNT_DELETE_YES") ?>
		<input class="checkbox" type="checkbox" id="deleteConfirm" name="deleteConfirm" required />
		<span class="checkmark"></span>
	</label>

	<div>
		<button class="back deleteCaseButton" type="button" id="cancel"><i class="ri-arrow-left-line"></i> <?= lang("ACCOUNT_DELETE_CANCEL") ?></button>
		<button class="button deleteCaseButton" type="submit" name="confirm_delete"><i class="ri-delete-bin-line"></i> <?= lang("ACCOUNT_DELETE") ?></button>
	</div>
</form>

<script src="/public/js/accountPassword.js"></script>

<?php
	require($_SERVER["DOCUMENT_ROOT"] . '/include/footer.php');
?>
