<?php
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_header.php");
	mainHeader("Administration utilisateur");
?>

<?php
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_roleFormat.php");
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_getUsers.php");
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/updateAdminUser.php");
?>

<script>
	function updateUser(userId) {
		var form = document.getElementById("form");

		var surnameElement = document.getElementById("surname_" + userId);
		var nameElement = document.getElementById("name_" + userId);
		var surname = surnameElement.innerHTML;
		var name = nameElement.innerHTML;

		var modifyButtonDisable = document.getElementsByClassName("modifybutton");

		for (let i = 0; i < modifyButtonDisable.length; i++) {
			const element = modifyButtonDisable[i];
			element.setAttribute("disabled", "true");
		}

		// var name = document.getElementById("name).innerHTML;

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

		// Transformer le texte en input
		surnameElement.replaceChildren(inputSurname);
		nameElement.replaceChildren(inputName);

		var inputUserId = document.createElement("input");
		inputUserId.setAttribute("type", "hidden");
		inputUserId.setAttribute("name", "userId");
		inputUserId.setAttribute("value", userId);

		form.appendChild(inputUserId);

		// document.getElementById("name).innerHTML = "<input type='text' id='name_' value='" + name + "'>";

		// Créer l'élément "confirm avec le bouton "Confirmer"
		var modifyButton = document.getElementById("modify_" + userId);

		confirmButton = document.createElement("input");
		confirmButton.setAttribute("type", "submit");
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
				foreach (getUsers() as $user) {
					$userId = $user['id'];
			?>
				<tr>
					<td id="surname_<?=$userId?>"><?=$user['surname']?></td>
					<td id="name_<?=$userId?>"><?=$user['name']?></td>
					<td><?=$user['email']?></td>
					<td><?=$user['birthdate']?></td>
					<td><?=roleFormat($user["student"], $user["teacher"], $user["admin"])?></td>
					<td><?=$user["classroom"]?></td>

					<td><button class="modifybutton" type="button" id="modify_<?=$userId?>" onclick="updateUser(<?=$userId?>)">Modifier</button></td>

					<td><button disabled>Supprimer</button></td>
				</tr>
			<?php
				}
			?>
		</tbody>
	</table>
</form>
