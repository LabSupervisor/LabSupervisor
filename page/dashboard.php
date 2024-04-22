<?php

	use
		LabSupervisor\app\repository\SessionRepository,
		LabSupervisor\app\repository\UserRepository;
	use function
		LabSupervisor\functions\mainHeader,
		LabSupervisor\functions\lang,
		LabSupervisor\functions\permissionChecker,
		LabSupervisor\functions\statusFormat;

	// Import header
	mainHeader(lang("DASHBOARD_TITLE"), true);

	// Ask for permissions
	permissionChecker(true, array(TEACHER));

	// Logic
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/adminSession.php");

	// Check if session is still open
	if (SessionRepository::getState($_SESSION["session"]) == 0) {
		header("Location: /sessions");
	}

	if (SessionRepository::getState($_SESSION["session"]) == 2) {
		$state = "pause";
		$stateButton = "<i class=\"ri-play-line\"></i>";
		$stateText = " | " . lang("DASHBOARD_PAUSE");
	} else {
		$state = "play";
		$stateButton = "<i class=\"ri-pause-line\"></i>";
		$stateText = "";
	}

	$view = "detail";
	$currentView = "default";
	if (isset($_GET["view"])) {
		if ($_GET["view"] == "default") {
			$view = "detail";
			$currentView = "default";
		} else {
			$view = "default";
			$currentView = "detail";
		}
	}
?>

<link rel="stylesheet" href="/public/css/dashboard.css">

<div class="mainbox button-container">
	<h2><?= SessionRepository::getName($_SESSION["session"]) . $stateText?></h2>
	<?php if (SessionRepository::getInfo($_SESSION["session"])[0]["description"]) {?>
		<a><?= SessionRepository::getInfo($_SESSION["session"])[0]["description"]?></a><br><br>
	<?php } ?>
	<div class="buttonBox">
		<form method="POST">
			<a class="back" href="/sessions"><i class="ri-arrow-left-line"></i> <?= lang("DASHBOARD_BACK") ?></a>
			<input type="hidden" name="sessionId" value="<?= $_SESSION["session"] ?>">
			<button class="button" type="submit" name="pause" value="<?= $state ?>" title="<?= lang("DASHBOARD_BUTTON_PAUSE") ?>"><?= $stateButton ?></button>
			<button class="button" type="submit" name="close"><i class="ri-close-circle-line"></i> <?= lang("DASHBOARD_SESSION_END") ?></button>
		</form>
		<form method="get">
			<input type="hidden" name="view" value="<?= $view ?>">
			<button class="button" type="submit"><i class="ri-arrow-left-right-line"></i> <?= lang("DASHBOARD_CHANGE_VIEW") ?></button>
		</form>
	</div>
</div>

<div class="mainbox table-container">
	<table>
		<?php if ($currentView == "default") { ?>
			<thead>
				<tr class="thead">
					<th><?= lang("DASHBOARD_STUDENT_NAME") ?></th>
					<th></th>
					<th><?= lang("DASHBOARD_SCREENSHARE") ?></th>
				</tr>
			</thead>
			<tbody>
			<?php
				// Select paticipants
				foreach (SessionRepository::getParticipant($_SESSION["session"]) as $value) {
					$userId = $value["iduser"];
					$participantName = UserRepository::getInfo(UserRepository::getEmail($userId));

					echo "<tr>";
					echo "<td class='col1'>" . $participantName["name"] . "</td>";
					echo "<td class='col1'>" . $participantName["surname"] . "</td>";
					echo "<td><button class='screenShareButton' title=\"" . lang("DASHBOARD_SCREENSHARE_OPEN") . "\" id='getScreenshare' onclick='window.open(\"/screenshare?userId=" . $userId . "\", \"_blank\")'><i class='ri-eye-line'></i></button></td>";

					$status = "";
					foreach (SessionRepository::getChapter($_SESSION["session"]) as $value) {
						$status = statusFormat($userId, SessionRepository::getChapterId($value["title"]), SessionRepository::getStatus(SessionRepository::getChapterId($value["title"]), $userId));

						echo "<td class='col2'>" . $status . "</td>";
					}
					echo "</tr>";
				}
			?>
			</tbody>
		<?php } else { ?>
			<thead>
			<tr class="thead">
				<th><?= lang("DASHBOARD_STUDENT_NAME") ?></th>
				<th></th>
				<th><?= lang("DASHBOARD_SCREENSHARE") ?></th>
				<th><?= lang("DASHBOARD_CHAPTER") ?></th>
				<th><?= lang("DASHBOARD_STATUS") ?></th>
			</tr>
			</thead>
			<tbody>
			<?php
				// Select paticipants
				foreach (SessionRepository::getParticipant($_SESSION["session"]) as $value) {
					$userId = $value["iduser"];

					// Get chapters and status
					$chapterList = "";
					$statusList = "";
					$index = 1;
					foreach (SessionRepository::getChapter($_SESSION["session"]) as $value) {
						$chapterList .= $index . ". " . $value["title"] . "<br>";
						$statusList .= statusFormat($userId, SessionRepository::getChapterId($value["title"]), SessionRepository::getStatus(SessionRepository::getChapterId($value["title"]), $userId));

						$index++;
					}

					$participantName = UserRepository::getInfo(UserRepository::getEmail($userId));

					// Fill table
					echo "<tr>";
					echo "<td class='col1'>" . $participantName["name"] . "</td>";
					echo "<td class='col1'>" . $participantName["surname"] . "</td>";
					echo "<td><button class='screenShareButton' title=\"" . lang("DASHBOARD_SCREENSHARE_OPEN") . "\" id='getScreenshare' onclick='window.open(\"/screenshare?userId=" . $userId . "\", \"_blank\")'><i class='ri-eye-line'></i></button></td>";
					echo "<td class='col2'>" . $chapterList . "</td>";
					echo "<td class='col3'>" . $statusList . "</td>";
					echo "</tr>";
				}
			?>
			</tbody>
		<?php } ?>
	</table>
</div>

<script src="/public/js/ft_lang.js"></script>
<script src="/public/js/ft_statusUpdate.js"></script>
<script src="/public/js/dashboardUpdate.js"></script>

<script>
	var idSession = <?= $_SESSION["session"] ?>;
</script>

<?php
	require($_SERVER["DOCUMENT_ROOT"] . '/include/footer.php');
?>
