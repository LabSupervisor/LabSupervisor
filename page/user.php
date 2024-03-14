<?php
	// Import header
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_header.php");
	mainHeader("Administration utilisateur");

	// Ask for permissions
	permissionChecker(true, array(ADMIN));

	// Logic
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_roleFormat.php");
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/updateAdminUser.php");
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/deleteAdminUser.php");
?>

<link rel="stylesheet" href="/public/css/user.css">

<?php
$tabClass = ClassroomRepository::getClassrooms();
// Convertit le tableau PHP en chaîne JSON pour l'utiliser en JavaScript
$classes_json = json_encode($tabClass);


?>


<script>
	// Create update fields
	function updateUser(userId) {
		var form = document.getElementById("form");

		var surnameElement = document.getElementById("surname_" + userId);
		var nameElement = document.getElementById("name_" + userId);
		var classRoomElement = document.getElementById("classroom_" + userId);
		var surname = surnameElement.innerHTML;
		var name = nameElement.innerHTML;
		var classRoom = surnameElement.innerHTML ;

		var modifyButtonDisable = document.getElementsByClassName("modifybutton");

		// Disable all modify buttons
		for (let i = 0; i < modifyButtonDisable.length; i++) {
			const element = modifyButtonDisable[i];
			element.setAttribute("disabled", "true");
		}

		var inputSurname = document.createElement("input");
		inputSurname.setAttribute("type", "text");
		inputSurname.setAttribute("id", "surname");
		inputSurname.setAttribute("name", "surname");
		inputSurname.setAttribute("class", "surname");
		inputSurname.setAttribute("placeholder", "<?= lang("USER_UPDATE_SURNAME") ?>");
		inputSurname.setAttribute("value", surname);

		var inputName = document.createElement("input");
		inputName.setAttribute("type", "text");
		inputName.setAttribute("id", "name");
		inputName.setAttribute("name", "name");
		inputName.setAttribute("class", "name");
		inputName.setAttribute("placeholder", "<?= lang("USER_UPDATE_NAME") ?>");
		inputName.setAttribute("value", name);

		var selectClassroom = document.createElement("select");
		selectClassroom.setAttribute("id", "selectedClassroom");
		selectClassroom.setAttribute("name", "selectedClassroom");
		// Récupère les classes depuis la chaîne JSON
		var classrooms = <?php echo $classes_json; ?>;
		// Ajoute les options au menu déroulant
		for (var i = 0; i < classrooms.length; i++) {
			var option = document.createElement("option");
			option.text = classrooms[i].name; // Utilise la propriété "name" de chaque objet
			selectClassroom.add(option);
		}

		// Ajoute un gestionnaire d'événements pour détecter le changement de sélection dans le menu déroulant
		selectClassroom.addEventListener("change", function() {

			// Récupère l'option sélectionnée dans le menu déroulant
			var selectedOption = selectClassroom.options[selectClassroom.selectedIndex];

			// Récupère la valeur de l'option sélectionnée (le nom de la classe)
			var selectedValue = selectedOption.value;

			// Met à jour la valeur de l'élément input caché pour cet utilisateur
			var hiddenInputId = "selectedClassroom_" + userId;
			document.getElementById(hiddenInputId).value = selectedValue;
		});

		surnameElement.replaceChildren(inputSurname);
		nameElement.replaceChildren(inputName);
		classRoomElement.replaceChildren(selectClassroom);

		var inputUserId = document.createElement("input");
		inputUserId.setAttribute("type", "hidden");
		inputUserId.setAttribute("name", "userId");
		inputUserId.setAttribute("value", userId);

		form.appendChild(inputUserId);

		var modifyButton = document.getElementById("modify_" + userId);

		confirmButton = document.createElement("input");
		confirmButton.setAttribute("type", "submit");
		confirmButton.setAttribute("name", "modify")
		confirmButton.setAttribute("class", "button")
		modifyButton.parentNode.replaceChild(confirmButton, modifyButton);
	}
</script>

<form id="form" method='POST'>
	<div class="mainbox table-container">
	<table>
		<thead>
				<tr class="thead">
				<th><?= lang("USER_UPDATE_SURNAME") ?></th>
				<th><?= lang("USER_UPDATE_NAME") ?></th>
				<th><?= lang("USER_UPDATE_EMAIL") ?></th>
				<th><?= lang("USER_UPDATE_ROLE") ?></th>
				<th><?= lang("USER_UPDATE_CLASS") ?></th>
				<th><?= lang("USER_UPDATE_ACTION") ?></th>
			</tr>
		</thead>
		<tbody>
			<?php
				foreach (UserRepository::getUsers() as $user) {
					// Only select active user
					if (UserRepository::isActive($user["email"])) {
						$userId = $user['id'];
			?>
			<tr>
				<td class="col1" id="surname_<?=$userId?>"><?=$user['surname']?></td>
				<td class="col2" id="name_<?=$userId?>"><?=$user['name']?></td>
				<td class="col3"><?=$user['email']?></td>
				<td class="col4"> <?=roleFormat($user['email'])?></td>
				<td class="col5" id="classroom_<?=$userId?>">
					<?php
					if ($user["classroom"]) {
						echo $user["classroom"];
					} else {
						echo lang("USER_UPDATE_CLASS_EMPTY");
					}
					?>
					<input type="hidden" name="selectedClassroom" id="selectedClassroom_<?=$userId?>">
				</td>
				<td class="col6"><button class="modifybutton button" type="button" id="modify_<?=$userId?>" onclick="updateUser(<?=$userId?>)"><?= lang("USER_UPDATE_MODIFY") ?></button>
				<form method="POST" action="#">
					<input type="hidden" name="userId" value="<?= $userId ?>">
					<button class="button" type="submit" name="send" id="delete_<?= $userId ?>"><?= lang("USER_UPDATE_DELETE") ?></button>
				</form>
				</td>
			</tr>
			<?php
					}
				}
			?>
		</tbody>
	</table>
	</div>
</form>
