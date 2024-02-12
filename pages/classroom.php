<?php
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_header.php");
	mainHeader("Classes");
?>

<?php
	permissionChecker(true, false, true, true);
?>

<?php
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_getClassroomId.php");
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_getClassroom.php");
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_getUserbyId.php");
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_getUserByClassroom.php");
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_getUserIdByClassroom.php");
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/updateClassroom.php");
?>


<h2>Ajouter des élèves</h2>

<?php
	foreach (getClassroom() as $classroom) { ?>
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
			$classId = $classroom["id"];
			$students = getUserIdByClassroom($classId);
			foreach ($students as $student) {
				$studInfos = getUserById($student["iduser"]);
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
		?>
		</tbody>
	</table>

	<form method="POST">
		<input type="hidden" name="class_id" value="<?php echo $classroom["id"]; ?>">
		<label for="student_id">Sélectionner un élève :</label>
		<select name="student_id" id="student_id">
			<?php
			// Fetch students not already in this class
			// Usefull line that i could used in register logic
			$students = getUserByClassroom($classroom["id"]);
			foreach ($students as $student) {
				echo "<option value='" . $student['id'] . "'>" . $student['name'] . " " . $student['surname'] . "</option>";
			}
			?>
		</select>
		<input type="submit" name="add_student" value="Ajouter">
	</form>

<?php
	}
?>
