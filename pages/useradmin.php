<?php
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_header.php");
	mainHeader("Administration utilisateur");
?>

<?php
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_getDBLog.php");
?>

<?php
$db = dbConnect();

$queryInfoUser = "SELECT id, surname, name, email , birthdate  from `user`";
$queryInfoUserPrep = $db->prepare($queryInfoUser);
if ($queryInfoUserPrep->execute()) {
	$infoUser = $queryInfoUserPrep->fetchAll();
}
?>

<table>
	<thead>
		<td>Nom</td>
		<td>Prénom</td>
		<td>e-Mail</td>
		<td>Anniversaire</td>
		<td>Rôle(s)</td>
		<td>Classe</td>
		<td></td>
		<td></td>
	</thead>
	<tbody>
		<?php
        foreach ($infoUser as $user) {
			$idUser = $user['id'];
			echo '<tr>';
			echo '<td id="surname_' . $idUser . '">' . $user['surname'] . '</td>';
			echo '<td id="name_' . $idUser . '">' . $user['name'] . '</td>';
			echo '<td id="email_' . $idUser . '">' . $user['email'] . '</td>';
			echo '<td id="birthdate_' . $idUser . '">' . $user['birthdate'] . '</td>';

			$queryRoleUser = "SELECT student, teacher, admin FROM role WHERE iduser = $idUser";
			$queryRoleUserPrep = $db->prepare($queryRoleUser);
			if ($queryRoleUserPrep->execute()){
				$roles = $queryRoleUserPrep->fetch();
				// gestion des rôles
				$userRoles = [];
				if ($roles['admin'] == 1) {
					$userRoles[] = 'Admin';
				}
				if ($roles['teacher'] == 1) {
					$userRoles[] = 'Enseignant';
				}
				if ($roles['student'] == 1) {
					$userRoles[] = 'Étudiant';
				}

				$userRolesStr = implode(', ', $userRoles);


			}
			echo '<td id="roles_' . $idUser . '">' . $userRolesStr . '</td>';


			// class
			$queryIdClassUser = "SELECT idclassroom FROM userclassroom WHERE iduser = '$idUser' ";
			$queryIdClassUserPrep = $db->prepare($queryIdClassUser);
			if ($queryIdClassUserPrep->execute()) {
				$idClassUser = $queryIdClassUserPrep->fetchColumn();
			}
			$queryNameClassUser= "SELECT name FROM classroom WHERE id = '$idClassUser'";
			$queryNameClassUserPrep= $db->prepare($queryNameClassUser);
			if ($queryNameClassUserPrep->execute()) {
				$NameClassUser = $queryNameClassUserPrep->fetchColumn();
			}
			echo '<td id="class_' . $idUser . '">' . $NameClassUser . '</td>';

			echo '<td id="confirmRow_' . $idUser . '"></td>';
			echo '<td> <button onclick="updateUser(' . $idUser . ')">Modifier</button></td>';
			echo '<td> <button>Supprimer</button></td>';
			echo '</tr>';
        }
		?>
	</tbody>
</table>

<script>
	function updateUser(userId){
		var surname = document.getElementById('surname_' + userId).innerHTML;
		var name = document.getElementById('name_' + userId).innerHTML;
		var email = document.getElementById('email_' + userId).innerHTML;
		var birthdate = document.getElementById('birthdate_' + userId).innerHTML;
		var roles = document.getElementById('roles_' + userId).innerHTML;
		var className = document.getElementById('class_' + userId).innerHTML;

		// Transformer le texte en input
		document.getElementById('surname_' + userId).innerHTML = '<input type="text" value="' + surname + '">';
		document.getElementById('name_' + userId).innerHTML = '<input type="text" value="' + name + '">';
		document.getElementById('email_' + userId).innerHTML = '<input type="text" value="' + email + '">';
		document.getElementById('birthdate_' + userId).innerHTML = '<input type="text" value="' + birthdate + '">';
		document.getElementById('roles_' + userId).innerHTML = '<input type="text" value="' + roles + '">';
		document.getElementById('class_' + userId).innerHTML = '<input type="text" value="' + className + '">';

		// Créer l'élément "confirm_" + userId avec le bouton "Confirmer"
		var confirmButton = document.createElement('button');
		confirmButton.textContent = 'Confirmer';
		confirmButton.onclick = function() {
			confirmUpdate(userId);
		};

		var confirmCell = document.createElement('td');
		confirmCell.appendChild(confirmButton);

		// Ajouter l'élément "confirm_" + userId à la ligne du tableau
		document.getElementById('confirmRow_' + userId).appendChild(confirmCell);

	}

	function confirmUpdate(userId) {
		alert('Mise à jour confirmée pour l\'utilisateur avec l\'ID ' + userId);


		location.reload();
	}

</script>


