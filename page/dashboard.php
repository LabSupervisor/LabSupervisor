<?php

	use
		LabSupervisor\app\repository\SessionRepository,
		LabSupervisor\app\repository\UserRepository,
		LabSupervisor\app\repository\ClassroomRepository;
	use function
		LabSupervisor\functions\mainHeader,
		LabSupervisor\functions\lang,
		LabSupervisor\functions\statusFormat,
		LabSupervisor\functions\nameFormat;

	// Import header
	mainHeader(lang("DASHBOARD_TITLE"), true);

	// Logic
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/adminSession.php");
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/openSession.php");

	$sessionInfo = SessionRepository::getInfo($_SESSION["session"])[0];

	// Percent system
	$percentDone = round(SessionRepository::getAllStatusDone($_SESSION["session"]) / (count(SessionRepository::getChapter($_SESSION["session"])) * count(SessionRepository::getParticipants($_SESSION["session"]))) * 100, 2);

	if (SessionRepository::getState($_SESSION["session"]) == 2) {
		$state = "pause";
		$stateButton = "<i class=\"ri-play-line\"></i>";
		$stateText = "<div class='pausedTitle'>" . lang("DASHBOARD_PAUSE") . "</div>";
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


	$userCount = 0;
	foreach (SessionRepository::getParticipants($_SESSION["session"]) as $value) {
		if (UserRepository::isActive($value["iduser"]) == true AND in_array(STUDENT, UserRepository::getRole($value["iduser"]))) {
			$userCount++;
		}
	}
?>

<link rel="stylesheet" href="/public/css/dashboard.css">

<div class="mainbox titlebox">
	<a class="back" href="/sessions"><i class="ri-arrow-left-line"></i> <?= lang("MAIN_BUTTON_BACK") ?></a>
	<h2><?= htmlspecialchars(SessionRepository::getName($_SESSION["session"])) . $stateText ?></h2>
	<?php if ($sessionInfo["description"]) { ?>
		<a><?= htmlspecialchars($sessionInfo["description"]) ?></a><br><br>
	<?php } ?>
	<div class="buttonBox">
		<form method="POST">
			<input type="hidden" name="sessionId" value="<?= $_SESSION["session"] ?>">
		<?php
		if (SessionRepository::getState($_SESSION["session"]) != 0) {
		?>
			<button class="button" type="submit" name="pause" value="<?= $state ?>" title="<?= lang("DASHBOARD_BUTTON_PAUSE") ?>"><?= $stateButton ?></button>
			<button class="button" type="submit" name="close"><i class="ri-close-circle-line"></i> <?= lang("DASHBOARD_SESSION_END") ?></button>
		<?php
		} else {
		?>
			<button class="button" type="submit" name="open" value="1"><i class="ri-door-open-line"></i><?= lang("SESSION_ACTION_OPEN") ?></button>
		<?php
		}
		?>
		</form>
		<form method="get">
			<input type="hidden" name="view" value="<?= $view ?>">
			<button class="button" type="submit"><i class="ri-arrow-left-right-line"></i> <?= lang("DASHBOARD_CHANGE_VIEW") ?></button>
		</form>
	</div>
	<div class="infoBox">
		<?= date("d F Y H:i", strtotime($sessionInfo["date"])) ?> | <?= htmlspecialchars(nameFormat($sessionInfo["idcreator"], false)) ?> - <?= htmlspecialchars(ClassroomRepository::getName($sessionInfo["idclassroom"])) ?>
	</div>
	<div class="progressBox">
		<div class="progressPercent" id="percentValue"> <?= $percentDone ?>% </div>
		<div class="progressBar" id="percentBar" style="width: <?= $percentDone ?>%"></div>
	</div>
</div>

<?php
	if ($userCount > 0) {
?>

<div class="mainbox maintable">
	<table>
		<?php if ($currentView == "default") { ?>
			<thead>
				<tr class="thead">
					<th class="col1"><?= lang("MAIN_SURNAME") ?></th>
					<th class="col2"><?= lang("MAIN_NAME") ?></th>
					<?php
						foreach (SessionRepository::getChapter($_SESSION["session"]) as $value) {
							echo "<th><i class=\"ri-information-line\" title='" . htmlspecialchars($value["title"]) . "'></i></th>";
						}
					?>
				</tr>
			</thead>
			<tbody>
			<?php
				// Select paticipants
				foreach (SessionRepository::getParticipants($_SESSION["session"]) as $value) {
					if (UserRepository::isActive($value["iduser"]) == true AND in_array(STUDENT, UserRepository::getRole($value["iduser"]))) {
						$userCount++;
						$userId = $value["iduser"];
						$participantName = UserRepository::getInfo($userId);

						echo "<tr>";
						echo "<td class='col1'>" . htmlspecialchars($participantName["surname"]) . "</td>";
						echo "<td class='col1'>" . htmlspecialchars($participantName["name"]) . "</td>";

						$status = "";
						foreach (SessionRepository::getChapter($_SESSION["session"]) as $value) {
							$status = statusFormat($userId, SessionRepository::getChapterId($value["title"]), SessionRepository::getStatus(SessionRepository::getChapterId($value["title"]), $userId));

							echo "<td class='col2'>" . $status . "</td>";
						}

						if (SessionRepository::getState($_SESSION["session"]) != 0) {
							echo "<td><button class='screenShareButton' title=\"" . lang("DASHBOARD_SCREENSHARE_OPEN") . "\" id='getScreenshare' onclick='window.open(\"/screenshare?userId=" . $userId . "\", \"_blank\")'><i class='ri-eye-line'></i></button></td>";
						}
						echo "</tr>";
					}
				}
			?>
			</tbody>
		<?php } else { ?>
			<thead>
			<tr class="thead">
				<th class="col1"><?= lang("MAIN_SURNAME") ?></th>
				<th class="col2"><?= lang("MAIN_NAME") ?></th>
				<th><?= lang("DASHBOARD_CHAPTER") ?></th>
				<th><?= lang("DASHBOARD_STATUS") ?></th>
			</tr>
			</thead>
			<tbody>
			<?php
				// Select paticipants
				foreach (SessionRepository::getParticipants($_SESSION["session"]) as $value) {
					if (UserRepository::isActive($value["iduser"]) == true AND in_array(STUDENT, UserRepository::getRole($value["iduser"]))) {
						$userId = $value["iduser"];

						// Get chapters and status
						$chapterList = "";
						$statusList = "";
						$index = 1;
						foreach (SessionRepository::getChapter($_SESSION["session"]) as $value) {
							$chapterList .= $index . " - " . $value["title"] . "<br>";
							$statusList .= statusFormat($userId, SessionRepository::getChapterId($value["title"]), SessionRepository::getStatus(SessionRepository::getChapterId($value["title"]), $userId));

							$index++;
						}

						$participantName = UserRepository::getInfo($userId);

						// Fill table
						echo "<tr>";
						echo "<td class='col1'>" . $participantName["surname"] . "</td>";
						echo "<td class='col1'>" . $participantName["name"] . "</td>";
						echo "<td class='col2'>" . $chapterList . "</td>";
						echo "<td class='col3'><div class='statusBallGroup'>" . $statusList . "</div></td>";
						if (SessionRepository::getState($_SESSION["session"]) != 0) {
							echo "<td><button class='screenShareButton' title=\"" . lang("DASHBOARD_SCREENSHARE_OPEN") . "\" id='getScreenshare' onclick='window.open(\"/screenshare?userId=" . $userId . "\", \"_blank\")'><i class='ri-eye-line'></i></button></td>";
						}
						echo "</tr>";
					}
				}
			?>
			</tbody>
		<?php } ?>
	</table>
</div>

<?php
	} else {
		echo "<div class='singleErrorContainer'><a class='singleErrorTitle'>" . lang("DASHBOARD_EMPTY_CLASSROOM") . "</a></div>";
	}
?>

<script src="/public/js/ft_statusUpdate.js"></script>
<script src="/public/js/ft_notify.js"></script>
<script src="/public/js/dashboardUpdate.js"></script>

<script>
	var idSession = <?= $_SESSION["session"] ?>;
</script>

<?php
	require($_SERVER["DOCUMENT_ROOT"] . '/include/footer.php');
?>
