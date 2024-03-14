<?php
	// Import header
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_header.php");
	mainHeader(lang("NAVBAR_PROFIL_ACCOUNT"));

	// Ask for permissions
	permissionChecker(true, array(ADMIN, STUDENT, TEACHER));

	// Logic
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/updateUser.php");
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_langFormat.php");

	$user = UserRepository::getInfo($_SESSION["login"]);

	// Vérifier si le formulaire de suppression a été soumis
	if (isset($_POST["confirm_delete"])) {
		UserRepository::delete($user["email"]);
		header("Location: /"); // Rediriger vers la page d'accueil après la suppression
		exit; // Terminer le script pour empêcher toute autre exécution
	}
?>

<link rel="stylesheet" href="/public/css/account.css">

<div class="mainbox AccountDiv">
	<form action="" method="post">
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

	<form id="confirmationForm" action="" method="post" style="display: none;">
		<h2>Confirmation de suppression</h2>
		<label for="yes_no">Voulez-vous supprimer définitivement ce compte ?
			<input type="radio" name="pick_up" value="deleteY" required />Oui
			<input type="radio" name="pick_up" value="deleteN" required />Non
		</label>
		<br>
		<button type="button" id="cancel">Annuler</button>
		<input type="submit" name="confirm_delete" value="Confirmer la suppression">
	</form>

	<?php if (!isset($_POST["confirm_delete"])) { ?>
		<!-- Bouton pour afficher le formulaire de suppression -->
		<button id="showDeleteForm">Supprimer le compte</button>
	<?php } ?>
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

	// Fonction pour afficher le "formulaire" de confirmation de suppression
	document.getElementById('showDeleteForm').addEventListener('click', function(event) {
		document.getElementById('confirmationForm').style.display = 'block';
		document.getElementById('showDeleteForm').style.display = 'none';
	});

	// Fonction pour annuler la suppression et afficher le formulaire de modification
	document.getElementById('cancel').addEventListener('click', function() {
		document.getElementById('confirmationForm').style.display = 'none';
		document.getElementById('showDeleteForm').style.display = 'block';
	});

	// Fonction pour gérer l'événement lors de la soumission du formulaire de confirmation de suppression
	document.getElementById('confirmationForm').addEventListener('submit', function(event) {
		var pick_up = document.querySelector('input[name="pick_up"]:checked').value;
		if (pick_up === 'deleteN') {
			// Si l'utilisateur a choisi "Non", réafficher le formulaire de base
			document.getElementById('confirmationForm').style.display = 'none';
			document.getElementById('showDeleteForm').style.display = 'block';
			event.preventDefault(); // Empêcher la soumission du formulaire
		}
	});
</script>
