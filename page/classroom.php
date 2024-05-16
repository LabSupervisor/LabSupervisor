<?php

	use
		LabSupervisor\app\repository\ClassroomRepository,
		LabSupervisor\app\repository\UserRepository;
	use function
		LabSupervisor\functions\mainHeader,
		LabSupervisor\functions\lang;

	// Import header
	mainHeader(lang("NAVBAR_CLASS"), true);

	// Logic
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/updateClassroom.php");

	$classrooms = ClassroomRepository::getClassrooms();
?>

<link rel="stylesheet" href="/public/css/classroom.css">

<?php
	if (!isset($_GET["id"])) {
		$_GET["id"] = $classrooms[0]["id"];
	}

	echo '<div class="mainGroup">';

	// Side menu
	echo '<div class="mainbox lateral">';
		echo "<h2>" . lang("CLASSROOM_NAME") . "</h2>";

		foreach ($classrooms as $value) {
			$selected = "";
			if ($_GET["id"] == $value["id"]) {
				$selected = "selected";
			}

			if ($value["active"] == "1") {
				echo '<div id="classroom_' . $value["id"] . '" class="classname ' . $selected . '" onclick="selectClass(' . $value["id"] . ')">' . $value["name"] . '</div>';
			}
		}
?>

		<form method="POST" onsubmit="loading()">
			<input type="text" name="addClassroom" placeholder="<?= lang("CLASSROOM_ADD_PLACEHOLDER") ?>" required>
			<button class="button" type="submit" title="<?= lang("CLASSROOM_ADD") ?>"><i class="ri-add-line"></i></button>
		</form>
	</div>

	<div id="contentClassroom_<?php echo $_GET["id"] ?>" class="mainbox maintable contentClassroom">
		<form method="POST" onsubmit="loading()">
			<input hidden name="classroomId" value="<?= $_GET["id"] ?>">
			<input class="classroomName" type="text" name="modifyName" value="<?= ClassroomRepository::getName($_GET["id"]) ?>"></input>
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
				$students = ClassroomRepository::getUsers($_GET["id"]);

				foreach ($students as $student) {
					if (UserRepository::isActive($student["iduser"])) {
						$studInfos = UserRepository::getInfo($student["iduser"]);
			?>
				<tr>
					<td><?= $studInfos["surname"] ?></td>
					<td><?= $studInfos["name"] ?></td>
					<td class="col3"><?= $studInfos["email"] ?></td>
					<td>
						<!-- Delete user form -->
						<form action="" method="post" onsubmit="loading()">
							<input type="hidden" name="classroomId" value="<?= $_GET["id"] ?>">
							<input type="hidden" name="removeStudent" value="<?= $student["iduser"] ?>">
							<button type="submit" class="button" title="<?= lang("CLASSROOM_STUDENT_REMOVE") ?>"><i class="ri-eraser-line"></i></button>
						</form>
					</td>
				</tr>
			<?php
					}
				}
			?>
					</tbody>
				</table>
			<?php

				// Free student list
				$freeStudents = ClassroomRepository::getUsersNotInClassroom();
				if ($freeStudents) {
					echo "<form class='freeStudents' method='POST' onsubmit='loading()'>";
					echo "<input type='hidden' name='classroomId' value=" . $_GET["id"] .">";
					echo "<select class='selectStudent' name='studentId' id='studentId'>";
					foreach ($freeStudents as $student)	{
						echo "<option value='" . $student['id'] . "'>" . $student['surname'] . " " . $student['name'] . "</option>";
					}
					echo "</select><button type='submit' class='button' name='addStudent'><i class=\"ri-add-line\"></i> " . lang("CLASSROOM_ADD") . "</button></form>";
				}
			?>
	</div>
</div>

<script src="/public/js/ft_selectClassroom.js"></script>
<script src="/public/js/ft_loading.js"></script>

<?php
	// Footer
	require($_SERVER["DOCUMENT_ROOT"] . '/include/footer.php');
?>
