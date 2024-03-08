<?php
	// Import header
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_header.php");
	mainHeader("Administration utilisateur");

	permissionChecker(true, array(admin));

	// Logic
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_roleFormat.php");
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/updateAdminUser.php");
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/deleteAdminUser.php");
?>

<script>
	// Create update fields
	function updateUser(userId) {
		var form = document.getElementById("form");

		var surnameElement = document.getElementById("surname_" + userId);
		var nameElement = document.getElementById("name_" + userId);
		var birthdateElement = document.getElementById("birthdate_" + userId);
		var surname = surnameElement.innerHTML;
		var name = nameElement.innerHTML;
		var birthdate = birthdateElement.innerHTML;

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
		inputSurname.setAttribute("value", surname);

		var inputName = document.createElement("input");
		inputName.setAttribute("type", "text");
		inputName.setAttribute("id", "name");
		inputName.setAttribute("name", "name");
		inputName.setAttribute("value", name);

		var inputBirthdate = document.createElement("input");
		inputBirthdate.setAttribute("type", "date");
		inputBirthdate.setAttribute("id", "birthdate");
		inputBirthdate.setAttribute("name", "birthdate");
		inputBirthdate.setAttribute("require", "true");
		inputBirthdate.setAttribute("value", birthdate);

		surnameElement.replaceChildren(inputSurname);
		nameElement.replaceChildren(inputName);
		birthdateElement.replaceChildren(inputBirthdate);

		var inputUserId = document.createElement("input");
		inputUserId.setAttribute("type", "hidden");
		inputUserId.setAttribute("name", "userId");
		inputUserId.setAttribute("value", userId);

		form.appendChild(inputUserId);

		var modifyButton = document.getElementById("modify_" + userId);

		confirmButton = document.createElement("input");
		confirmButton.setAttribute("type", "submit");
		confirmButton.setAttribute("name", "modify")
		modifyButton.parentNode.replaceChild(confirmButton, modifyButton);
	}
</script>

<form id="form" method='POST'>
	<table>
		<thead>
			<td>Nom</td>
			<td>Prénom</td>
			<td>Adresse mail</td>
			<td>Anniversaire</td>
			<td>Rôle</td>
			<td>Classe</td>
			<td></td>
			<td></td>
		</thead>
		<tbody>
			<?php
				foreach (UserRepository::getUsers() as $user) {
					// Only select active user
					if (UserRepository::isActive($user["email"])) {
						$userId = $user['id'];
			?>
				<tr>
					<td id="surname_<?=$userId?>"><?=$user['surname']?></td>
					<td id="name_<?=$userId?>"><?=$user['name']?></td>
					<td><?=$user['email']?></td>
					<td id="birthdate_<?=$userId?>"><?=$user['birthdate']?></td>
					<td><?=roleFormat($user["student"], $user["teacher"], $user["admin"])?></td>
					<td><?=$user["classroom"]?></td>
					<td><button class="modifybutton" type="button" id="modify_<?=$userId?>" onclick="updateUser(<?=$userId?>)">Modifier</button></td>
					<td>
					<form method="POST" action="#">
						<input type="hidden" name="userId" value="<?= $userId ?>">
						<button class="deletebutton" type="submit" name="send" id="delete_<?= $userId ?>">Supprimer</button>
					</form>

					</td>
				</tr>
			<?php
					}
				}
			?>
		</tbody>
	</table>
</form>
