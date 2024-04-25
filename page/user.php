<?php

	use
		LabSupervisor\app\repository\UserRepository,
		LabSupervisor\app\repository\ClassroomRepository;
	use function
		LabSupervisor\functions\mainHeader,
		LabSupervisor\functions\lang,
		LabSupervisor\functions\permissionChecker,
		LabSupervisor\functions\roleFormat;

	// Import header
	mainHeader(lang("NAVBAR_USER"), true);

	// Ask for permissions
	permissionChecker(true, array(ADMIN));

	// Logic
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

<form id="form" method='POST'>
	<div class="mainbox maintable">
	<table>
		<thead>
			<tr class="thead">
				<th><?= lang("USER_UPDATE_SURNAME") ?></th>
				<th><?= lang("USER_UPDATE_NAME") ?></th>
				<th><?= lang("USER_UPDATE_EMAIL") ?></th>
				<th><?= lang("USER_UPDATE_ROLE") ?></th>
				<th><?= lang("USER_UPDATE_CLASS") ?></th>
				<th><?= lang("USER_UPDATE_ACTION") ?></th>
			</tr>
		</thead>
		<tbody>
			<?php
				foreach (UserRepository::getUsers() as $user) {
					// Only select active user
					if (UserRepository::isActive($user["email"])) {
						$userId = $user['id'];
			?>
			<tr>
				<td class="col1" id="surname_<?=$userId?>"><?=$user['surname']?></td>
				<td class="col2" id="name_<?=$userId?>"><?=$user['name']?></td>
				<td class="col3"><?=$user['email']?></td>
				<td class="col4" id="role_<?=$userId?>"><?=roleFormat($user['email'])?></td>
				<td class="col5" id="classroom_<?=$userId?>">
					<?php
					if ($user["classroom"]) {
						echo $user["classroom"];
					} else {
						echo lang("USER_UPDATE_CLASS_EMPTY");
					}
					?>
					<input type="hidden" name="classroom" id="classroom_<?=$userId?>">
				</td>
				<?php
					$classroomIdUser = ClassroomRepository::getUserClassroom($userId);
					if (!$classroomIdUser)
						$classroomIdUser = 0;
					$roleIdUser = UserRepository::getRole(UserRepository::getEmail($userId))[0]["idrole"];
				?>
				<td class="col6"><button class="modifybutton button" type="button" id="modify_<?= $userId ?>" onclick="updateUser(<?= $userId ?>, <?= $classroomIdUser ?>, <?= $roleIdUser ?>)"><?= lang("USER_UPDATE_MODIFY") ?></button>
				<form method="POST">
					<input type="hidden" name="userId" value="<?= $userId ?>">
					<button class="button" type="submit" name="send" id="delete_<?= $userId ?>"><?= lang("USER_UPDATE_DELETE") ?></button>
				</form>
				</td>
			</tr>
			<?php
					}
				}
			?>
		</tbody>
	</table>
	</div>
</form>

<script src="/public/js/ft_lang.js"></script>
<script src="/public/js/ft_updateUser.js"></script>

<?php
	require($_SERVER["DOCUMENT_ROOT"] . '/include/footer.php');
?>
