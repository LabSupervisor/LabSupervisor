<?php

	use
		LabSupervisor\app\repository\UserRepository,
		LabSupervisor\app\repository\ClassroomRepository;
	use function
		LabSupervisor\functions\mainHeader,
		LabSupervisor\functions\lang,
		LabSupervisor\functions\roleFormat;

	// Import header
	mainHeader(lang("NAVBAR_USER"), true);

	// Logic
	echo '<script src="/public/js/function/popup.js"></script>';
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/updateAdminUser.php");
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/deleteAdminUser.php");

	// Get classrooms
	$classrooms = ClassroomRepository::getClassrooms();

	// Get roles
	$roles = UserRepository::getRoles();
?>

<script>
	var classrooms = <?= json_encode($classrooms) ?>;
	var roles = <?= json_encode($roles) ?>;
</script>

<link rel="stylesheet" href="/public/css/user.css">

<form id="form" method='POST' onsubmit="loading()">
	<div class="mainbox maintable">
		<table>
			<thead>
				<tr class="thead">
					<th><?= lang("MAIN_SURNAME") ?></th>
					<th><?= lang("MAIN_NAME") ?></th>
					<th><?= lang("USER_UPDATE_EMAIL") ?></th>
					<th><?= lang("USER_UPDATE_ROLE") ?></th>
					<th><?= lang("USER_UPDATE_CLASS") ?></th>
					<th><?= lang("USER_UPDATE_ACTION") ?></th>
				</tr>
			</thead>
			<tbody>
			<?php
			if (!isset($_GET["page"])) {
				$_GET["page"] = 1;
			}

			$i = 0;
			$max = 10;
			foreach (UserRepository::getUsers() as $user) {
				if ($i >= ($_GET["page"] -1) * $max && $i < $_GET["page"] * $max) {
					$userId = $user['id'];
			?>
				<tr>
					<td class="col1" id="surname_<?= $userId ?>"><?= htmlspecialchars(ucfirst(strtolower($user['surname']))) ?></td>
					<td class="col2" id="name_<?= $userId ?>"><?= htmlspecialchars(ucfirst(strtolower($user['name']))) ?></td>
					<td class="col3"><?= $user['email'] ?></td>
					<td class="col4" id="role_<?= $userId ?>"><?= roleFormat($user['id']) ?></td>
					<td class="col5" id="classroom_<?= $userId ?>">
						<?php
						if ($user["classroom"]) {
							echo htmlspecialchars(ClassroomRepository::getName($user["classroom"]));
						} else {
							if (in_array(TEACHER, UserRepository::getRole($userId))) {
								$classroomList = "";
								foreach (ClassroomRepository::getTeacherClassroom($userId) as $value) {
									$classroomList .= ClassroomRepository::getName($value["id"]) . " - ";
								}
								$classroomList = substr($classroomList, 0, -2);
								echo "<div class='col5' title='" . htmlspecialchars($classroomList) . "'>" . htmlspecialchars($classroomList) . "</div>";
							} else {
								echo lang("USER_UPDATE_CLASS_EMPTY");
							}
						}
						?>
						<input type="hidden" name="classroom" id="classroom_<?=$userId?>">
					</td>
					<?php
						$classroomIdUser = ClassroomRepository::getUserClassroom($userId);
						if (!$classroomIdUser)
							$classroomIdUser = 0;
					?>
					<td class="col6">
						<?php
							if ($_SESSION["login"] != $userId) {
						?>

						<button class="button" type="button" id="modify_<?= $userId ?>" title="<?= lang("USER_UPDATE_MODIFY") ?>" onclick="updateUser(<?= $userId ?>, <?= $classroomIdUser ?>, <?= UserRepository::getRole($userId)[0] ?>)"><i class="ri-pencil-line"></i></button>

						<form method="POST" onsubmit="return confirmForm('<?= lang('USER_UPDATE_DELETE_CONFIRMATION') ?>');">
							<input type="hidden" name="userId" value="<?= $userId ?>">
							<button class="link" type="submit" name="send" id="delete_<?= $userId ?>"><i class="ri-delete-bin-line"></i> <?= lang("USER_UPDATE_DELETE") ?></button>
						</form>

						<?php
							} else {
								echo '<a class="button account" href="/compte"><i class="ri-account-circle-line"></i>' . lang("NAVBAR_PROFIL_ACCOUNT") . '</a>';
							}
						?>
					</td>
				</tr>
			<?php
				}
				$i++;
			}
			?>
			</tbody>
		</table>
		<form class="pageGroup" method="GET" onsubmit="loading()">
			<?php
				if ($_GET["page"] != 1) {
			?>
			<button class="button" type="submit" name="page" value="<?= $_GET["page"] -1 ?>"><i class="ri-arrow-left-s-line"></i></button>
			<?php
				} else {
			?>
			<button class="button" disabled><i class="ri-arrow-left-s-line"></i></button>
			<?php
				}
			?>
			<input class="pageNumber" id="pageNumber" type="number" value="<?= $_GET["page"] ?>" min="1" max="<?= ceil(count(UserRepository::getUsers()) / $max)?>">
			<?php
				if (count(UserRepository::getUsers()) > $_GET["page"] * $max) {
			?>
			<button class="button" type="submit" name="page" value="<?= $_GET["page"] +1 ?>"><i class="ri-arrow-right-s-line"></i></button>
			<?php
				} else {
			?>
			<button class="button" disabled><i class="ri-arrow-right-s-line"></i></button>
			<?php
				}
			?>
		</form>
	</div>
</form>

<script src="/public/js/pageSelector.js"></script>
<script src="/public/js/function/updateUser.js"></script>
<script src="/public/js/function/loading.js"></script>
<script src="/public/js/function/popupConfirm.js"></script>

<?php
	require($_SERVER["DOCUMENT_ROOT"] . '/include/footer.php');
?>
