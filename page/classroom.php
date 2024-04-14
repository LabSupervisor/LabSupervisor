<?php

	use
		LabSupervisor\app\repository\ClassroomRepository,
		LabSupervisor\app\repository\UserRepository;
	use function
		LabSupervisor\functions\mainHeader,
		LabSupervisor\functions\lang,
		LabSupervisor\functions\permissionChecker;

	// Import header
	mainHeader(lang("NAVBAR_CLASS"));

	// Ask for permissions
	permissionChecker(true, array(TEACHER));

	// Logic
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/updateClassroom.php");
?>

<h2>Ajouter des élèves</h2>

<?php
	foreach (ClassroomRepository::getClassrooms() as $classroom) {
		if (ClassroomRepository::isActive($classroom["name"])) {?>

	<h3>Classe <?php echo $classroom["name"]; ?></h3>
	<table>
		<thead>
			<tr>
				<th>Nom</th>
				<th>Prénom</th>
				<th>Email</th>
			</tr>
		</thead>
		<tbody>
		<?php
			// Fetch students for the current class
			$students = ClassroomRepository::getUsers($classroom["name"]);
			foreach ($students as $student) {
				if (UserRepository::isActive(UserRepository::getEmail($student["iduser"]))) {
					$studInfos = UserRepository::getInfo(UserRepository::getEmail($student["iduser"]));

					if (isset($studInfos)) {
		?>
				<tr>
					<td><?= $studInfos["name"] ?></td>
					<td><?= $studInfos["surname"] ?></td>
					<td><?= $studInfos["email"] ?></td>
					<td>
						<form action="" method="post">
							<input type="hidden" name="class_id" value="<?= $classroom["id"] ?>">
							<input type="hidden" name="remove_student" value="<?= $student["iduser"] ?>">
							<input type="submit" value="Retirer">
						</form>
					</td>
				</tr>

		<?php
					}
				}
			}
		?>
		</tbody>
	</table>
		<?php
			// Fetch students not already in this class
			$students = ClassroomRepository::getUsersNotInClassroom();
			if ($students) {
				echo "<form method='POST'>";
				echo "<input type='hidden' name='class_id' value=" . $classroom["id"] .">";
				echo "<select name='student_id' id='student_id'><label for='student_id'>Sélectionner un élève :</label>";
				foreach ($students as $student) {
					echo "<option value='" . $student['id'] . "'>" . $student['name'] . " " . $student['surname'] . "</option>";
				}
				echo "</select><input type='submit' name='add_student' value='Ajouter'></form>";
			}
		}
	}
?>

<?php
	require($_SERVER["DOCUMENT_ROOT"] . '/include/footer.php');
?>
