<?php
	use
		LabSupervisor\app\repository\ClassroomRepository,
		LabSupervisor\app\repository\UserRepository;
	use function
		LabSupervisor\functions\mainHeader,
		LabSupervisor\functions\lang,
		LabSupervisor\functions\permissionChecker;

	// Import header
	mainHeader(lang("NAVBAR_CLASS"), true);

	// Ask for permissions
	permissionChecker(true, array(TEACHER));

	// Logic
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/updateClassroom.php");
?>

<link rel="stylesheet" href="/public/css/classroom.css">

<script>
	// Side menu, display classroom's students
	function selectClass(id) {
		try	{
			// Classroom's name
			document.querySelector('.classname[selected]').removeAttribute('selected');
			document.getElementById('class-'+id).setAttribute('selected','');

			// Classroom's students
			document.querySelector('.content-class[selected]').removeAttribute('selected');
			document.getElementById('content-class-'+id).setAttribute('selected','');
		} catch(e) {
			console.error(e.stack);
		}
	}
</script>

<?php
	$classrooms = ClassroomRepository::getClassrooms();

	// Side menu
	echo '<div id="lateral-selector" class="mainbox">';

	for($i = 0; $i < count($classrooms); $i++) {
		$classroom = $classrooms[$i];

		$selected = "";
		if($i == 0) // Focus first class
			$selected = "selected";

		if ($classroom["active"] == "1") {
			echo '<div id="class-' . $classroom["id"] . '" class="classname" ' . $selected . ' onclick="selectClass(' . $classroom["id"] . ')">' . $classroom["name"] . '</div>';
		}

	}
	echo '</div>';

	// Choosen classroom display
	for($i = 0; $i < count($classrooms); $i++) {
		$classroom = $classrooms[$i];

		if ($classroom["active"] == "1") {
			$selected = "";
			// Focus first class
			if ($i == 0)
				$selected = "selected";
?>

			<div id="content-class-<?php echo $classroom["id"]?>" class="mainbox content-class" <?php echo $selected?>>
			<h2><?php echo $classroom["name"]?></h2>
			<table>
				<thead>
					<tr>
						<th>Nom</th>
						<th>Prénom</th>
						<th>Email</th>
						<th></th>
					</tr>
				</thead>
				<tbody>

		<?php
			// Display classroom's student
			$students = ClassroomRepository::getUsers($classroom["name"]);
			foreach ($students as $student) {
				if (UserRepository::isActive(UserRepository::getEmail($student["iduser"]))) {
					$studInfos = UserRepository::getInfo(UserRepository::getEmail($student["iduser"]));

					if (isset($studInfos)) {
		?>
						<tr>
							<td><?= $studInfos["surname"] ?></td>
							<td><?= $studInfos["name"] ?></td>
							<td><?= $studInfos["email"] ?></td>
							<td>
								<!-- Delete user form -->
								<form action="" method="post">
									<input type="hidden" name="class_id" value="<?= $classroom["id"] ?>">
									<input type="hidden" name="remove_student" value="<?= $student["iduser"] ?>">
									<input type="submit" class="button" value="Retirer">
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

			// Free student list
			$freeStudents = ClassroomRepository::getUsersNotInClassroom();
			if ($freeStudents) {
				echo "<form class='free-students' method='POST'>";
				echo "<input type='hidden' name='class_id' value=" . $classroom["id"] .">";
				echo "<select class='select-student' name='student_id' id='student_id'><label for='student_id'>Sélectionner un élève :</label>";
				foreach ($freeStudents as $student)	{
					echo "<option value='" . $student['id'] . "'>" . $student['name'] . " " . $student['surname'] . "</option>";
				}
				echo "</select><input type='submit' class='button' name='add_student' value='Ajouter'></form>";
			}
		?>
			</div>
		<?php
		}
	}

	// Footer
	require($_SERVER["DOCUMENT_ROOT"] . '/include/footer.php');
?>
