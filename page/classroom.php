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

<?php
	$classrooms = ClassroomRepository::getClassrooms();

	// Side menu
	echo '<div class="mainGroup"><div id="lateralSelector" class="mainbox">';
	echo "<h2>" . lang("CLASSROOM_NAME") . "</h2>";

	for($i = 0; $i < count($classrooms); $i++) {
		$classroom = $classrooms[$i];

		$selected = "";
		// Focus first class
		if($i == 0)
			$selected = "selected";

		if ($classroom["active"] == "1") {
			echo '<div id="classroom_' . $classroom["id"] . '" class="classname" ' . $selected . ' onclick="selectClass(' . $classroom["id"] . ')">' . $classroom["name"] . '</div>';
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

			<div id="contentClassroom_<?php echo $classroom["id"]?>" class="mainbox maintable contentClassroom" <?php echo $selected?>>

			<form method="POST">
				<input hidden name="classroomId" value="<?= ClassroomRepository::getId($classroom["name"]) ?>">
				<input type="text" name="modifyName" value="<?= $classroom["name"] ?>"></input>
				<button class="button" type="submit"><i class="ri-pencil-line"></i></button>
			</form>
			<table>
				<thead>
					<tr>
						<th><?= lang("CLASSROOM_STUDENT_SURNAME") ?></th>
						<th><?= lang("CLASSROOM_STUDENT_NAME") ?></th>
						<th><?= lang("CLASSROOM_STUDENT_EMAIL") ?></th>
						<th></th>
					</tr>
				</thead>
				<tbody>

		<?php
			// Display classroom's student
			$students = ClassroomRepository::getUsers($classroom["name"]);
			foreach ($students as $student) {
				if (UserRepository::isActive($student["iduser"])) {
					$studInfos = UserRepository::getInfo($student["iduser"]);

					if (isset($studInfos)) {
		?>
						<tr>
							<td><?= $studInfos["surname"] ?></td>
							<td><?= $studInfos["name"] ?></td>
							<td class="col3"><?= $studInfos["email"] ?></td>
							<td>
								<!-- Delete user form -->
								<form action="" method="post">
									<input type="hidden" name="classroomId" value="<?= $classroom["id"] ?>">
									<input type="hidden" name="removeStudent" value="<?= $student["iduser"] ?>">
									<button type="submit" class="button" title="<?= lang("CLASSROOM_STUDENT_REMOVE") ?>"><i class="ri-eraser-line"></i></button>
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
				echo "<form class='freeStudents' method='POST'>";
				echo "<input type='hidden' name='classroomId' value=" . $classroom["id"] .">";
				echo "<select class='selectStudent' name='studentId' id='studentId'>";
				foreach ($freeStudents as $student)	{
					echo "<option value='" . $student['id'] . "'>" . $student['surname'] . " " . $student['name'] . "</option>";
				}
				echo "</select><button type='submit' class='button' name='addStudent'><i class=\"ri-add-line\"></i> " . lang("CLASSROOM_ADD") . "</button></form>";
			}
		?>
			</div>
		<?php
		}
	}
?>
</div>

<script src="/public/js/ft_selectClassroom.js"></script>

<?php
	// Footer
	require($_SERVER["DOCUMENT_ROOT"] . '/include/footer.php');
?>
