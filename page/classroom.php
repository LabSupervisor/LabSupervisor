<?php

	use
		LabSupervisor\app\repository\ClassroomRepository,
		LabSupervisor\app\repository\UserRepository,
		LabSupervisor\app\repository\SessionRepository;
	use function
		LabSupervisor\functions\mainHeader,
		LabSupervisor\functions\lang;

	// Logic
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/updateClassroom.php");

	if (in_array(ADMIN, UserRepository::getRole($_SESSION["login"]))) {
		$classrooms = ClassroomRepository::getClassrooms();
	} else {
		$classrooms = ClassroomRepository::getTeacherClassroom($_SESSION["login"]);
	}
	$classroomList = array();
	foreach ($classrooms as $value) {
		array_push($classroomList, $value["id"]);
	}

	if (!isset($_GET["id"])) {
		$_GET["id"] = $classrooms[0]["id"];
	} else {
		if (!in_array($_GET["id"], $classroomList)) {
			header("Location: /classroom");
		}
	}

	// Import header
	mainHeader(lang("NAVBAR_CLASS"), true);

	$students = ClassroomRepository::getUsers($_GET["id"]);
	$freeStudents = ClassroomRepository::getUsersNotInClassroom();

	$deletable = "";
	foreach (SessionRepository::getSessions() as $sessionId) {
		if ($_GET["id"] == $sessionId["idclassroom"]) {
			$deletable = "disabled";
		}
	}

	if (count(ClassroomRepository::getUsers($_GET["id"])) > 0) {
		$deletable = "disabled";
	}
?>

<link rel="stylesheet" href="/public/css/classroom.css">

<div class='addPopup' id='addStudentPopup' tabindex='-1'>
	<div class="mainbox popupbox">
		<h2><?= lang("CLASSROOM_ADD_STUDENT_TITLE") ?></h2>

		<?php
			if ($freeStudents) {
		?>
		<?= lang("CLASSROOM_ADD_STUDENT_INFO") ?>
		<form class="selectStudentForm" method="POST" onsubmit="loading()">
			<input type='hidden' name='classroomId' value="<?= $_GET["id"] ?>">
			<select class="selectStudent" name="studentId[]" multiple required>
			<?php
				foreach ($freeStudents as $student)	{
					echo "<option value='" . $student['id'] . "'>" . htmlspecialchars($student['surname']) . " " . htmlspecialchars($student['name']) . "</option>";
				}
			?>
			</select>

			<div>
				<button class="link" onclick="hidePopup('addStudentPopup')"><i class="ri-arrow-left-line"></i> <?= lang("MAIN_CANCEL") ?></button>
				<button class="button" type="submit" name="addStudent"><?= lang("MAIN_ADD") ?></button>
			</div>
		</form>

		<?php
			} else {
		?>
			<?= lang("CLASSROOM_ADD_STUDENT_EMPTY") ?><button class="link" onclick="hidePopup('addStudentPopup')"><i class="ri-arrow-left-line"></i><?= lang("MAIN_CANCEL") ?></button>
		<?php
			}
		?>
	</div>
</div>

<div class='addPopup' id='addClassroomPopup' tabindex='-1'>
	<div class="mainbox popupbox">
		<h2><?= lang("CLASSROOM_ADD_CLASSROOM_TITLE") ?></h2>

		<form class="selectStudentForm" method="POST" onsubmit="loading()">
			<input class="addClassroomInput" type="text" name="addClassroom" placeholder="<?= lang("CLASSROOM_ADD_CLASSROOM_PLACEHOLDER") ?>" maxlength="50" required>

			<div>
				<button class="link" onclick="hidePopup('addClassroomPopup')"><i class="ri-arrow-left-line"></i> <?= lang("MAIN_CANCEL") ?></button>
				<button class="button" type="submit" title="<?= lang("MAIN_ADD") ?>"><i class="ri-add-line"></i></button>
			</div>
		</form>
	</div>
</div>

<div class="mainGroup">
	<div class="mainbox lateral">

		<div class="classnameGroup">
			<h2 class="classroomListTitle"><?= lang("CLASSROOM_NAME") ?></h2>
			<button class="button" onclick="showPopup('addClassroomPopup')"><i class="ri-add-line"></i></button>
		</div>

		<?php
			if (count($classroomList) > 0) {
				if (isset($_GET["id"])) {
					foreach ($classrooms as $value) {
						$selected = "";
						if ($_GET["id"] == $value["id"]) {
							$selected = "selected";
						}

						if ($value["active"] == "1") {
							echo '
							<form method="GET" onsubmit="loading()">
								<button class="classname ' . $selected . '" type="submit" name="id" value="' . $value["id"] . '">' . htmlspecialchars($value["name"]) . '</button>
							</form>';
						}
					}
				}
			}
		?>

	</div>

	<?php
		if (count($classroomList) > 0) {
	?>
	<div class="mainbox maintable studentList">
		<div class="classroomTitleBox">
			<div class="classroomTitleItem">
				<h2 class="classroomName" title="<?= ClassroomRepository::getName($_GET["id"]) ?>"><?= ClassroomRepository::getName($_GET["id"]) ?></h2>
				<button class="button" type="submit"><i class="ri-pencil-line"></i></button>

				<form method="POST" onsubmit="return confirmForm('<?= lang('CLASSROOM_DELETE_CLASSROOM_CONFIRMATION') ?>');">
					<button class="button deleteClassroom" type="submit" name="deleteClassroom" value="<?= $_GET["id"] ?>" <?= $deletable ?>><i class="ri-delete-bin-line"></i></button>
				</form>
			</div>
			<div class="classroomTitleItem">
				<a class="studentNumber" title="<?= lang("MAIN_ROLE_STUDENT") ?>"><?= count($students) ?> <i class="ri-group-line"></i></a>

				<button class="button addStudent" onclick="showPopup('addStudentPopup')"><i class="ri-add-line"></i></button>
			</div>
		</div>

		<?php
			if (count($students) > 0) {
		?>

		<table>
			<thead>
				<tr>
					<th><?= lang("MAIN_SURNAME") ?></th>
					<th><?= lang("MAIN_NAME") ?></th>
					<th><?= lang("CLASSROOM_STUDENT_EMAIL") ?></th>
					<th></th>
				</tr>
			</thead>
			<tbody>

			<?php
				// Display classroom's student
				foreach ($students as $student) {
					if (UserRepository::isActive($student["iduser"])) {
						$studInfos = UserRepository::getInfo($student["iduser"]);
			?>

				<tr>
					<td><?= htmlspecialchars(ucfirst(strtolower($studInfos["surname"]))) ?></td>
					<td><?= htmlspecialchars(ucfirst(strtolower($studInfos["name"]))) ?></td>
					<td class="col3"><?= htmlspecialchars($studInfos["email"]) ?></td>
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
			} else {
				echo "<a class='singleErrorTitle'>" . lang("CLASSROOM_EMPTY") . "</a>";
			}
		?>

	</div>
	<?php
		} else {
			echo "<div class='singleErrorContainer'><a class='singleErrorTitle'>" . lang("CLASSROOM_LIST_EMPTY") . "</a></div>";
		}
	?>
</div>

<script src="/public/js/function/loading.js"></script>
<script src="/public/js/function/popup.js"></script>
<script src="/public/js/function/popupConfirm.js"></script>
<script src="/public/js/function/showPopup.js"></script>

<?php
	// Footer
	require($_SERVER["DOCUMENT_ROOT"] . '/include/footer.php');
?>
