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
	} else {
		$state = "play";
	}
?>

<link rel="stylesheet" href="/public/css/dashboard.css">

<div class="mainbox button-container">
	<h2><?= SessionRepository::getName($_SESSION["session"])?></h2>
	<?php if (SessionRepository::getInfo($_SESSION["session"])[0]["description"]) {?>
		<a><?= SessionRepository::getInfo($_SESSION["session"])[0]["description"]?></a><br><br>
	<?php } ?>
	<div class="buttonBox">
		<form method="POST">
			<a class="button" href="/sessions"><?= lang("DASHBOARD_BACK") ?></a>
			<input type="hidden" name="sessionId" value="<?= $_SESSION["session"] ?>">
			<input class="button" type="submit" name="modify" value="<?= lang("SESSION_UPDATE") ?>">
			<button class="button" type="submit" title="<?= lang("DASHBOARD_BUTTON_PAUSE") ?>" name="pause" value="<?= $state ?>"><i class="ri-<?= $state ?>-line"></i></button>
			<input class="button" type="submit" name="close" value="<?= lang("DASHBOARD_SESSION_END") ?>">
		</form>
		<form method="get">
			<?php
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
			<input type="hidden" name="view" value="<?= $view ?>">
			<input class="button" type="submit" value="<?= lang("DASHBOARD_CHANGE_VIEW") ?>">
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
						if ($state == "pause") {
							$status = "<div class='statusBall'></div>";
						} else {
							$status = statusFormat($userId, SessionRepository::getChapterId($value["title"]), SessionRepository::getStatus(SessionRepository::getChapterId($value["title"]), $userId));
						}

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
						if ($state == "pause") {
							$statusList .= "<div class='statusBall'></div>";
						} else {
							$statusList .= statusFormat($userId, SessionRepository::getChapterId($value["title"]), SessionRepository::getStatus(SessionRepository::getChapterId($value["title"]), $userId));
						}

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

<script>
	var idSession = <?= $_SESSION["session"] ?>;
</script>

<script>
	setInterval(() => {
		fetch("/connect", {
			method: 'post',
			headers: {
			'Accept': 'application/json',
			'Content-Type': 'application/json'
			},
			body: JSON.stringify({
				"ask": "get_status",
				"idSession": idSession,
			})
		}).then((response) => {
			return response.json()
		}).then((res) => {
			statusUpdate(res)
		}).catch((error) => {
			console.log(error);
		})

		function statusUpdate(status) {
			Object.entries(status.Response).forEach(([participant, indexParticipant]) => {
				Object.entries(status.Response[participant]).forEach(([chapter, indexChapter]) => {

					DOMElement = document.getElementById(participant + "_" + chapter);

					let statusDisplay = "";
					let text = "<?= lang("DASHBOARD_STATUS_WAITING") ?>";
					if (status.Response[participant][chapter] == 0) {
						statusDisplay = "";
					}
					if (status.Response[participant][chapter] == 1) {
						statusDisplay = "statusRed";
						text = "<?= lang("DASHBOARD_STATUS_RED") ?>";
					}
					if (status.Response[participant][chapter] == 2) {
						statusDisplay = "statusYellow";
						text = "<?= lang("DASHBOARD_STATUS_YELLOW") ?>";
					}
					if (status.Response[participant][chapter] == 3) {
						statusDisplay = "statusGreen";
						text = "<?= lang("DASHBOARD_STATUS_GREEN") ?>";
					}

					DOMElement.className = "statusBall " + statusDisplay;
					DOMElement.innerHTML = "<a>" + text + "</a>";
				})
			})
		}
	}, 3000);
</script>

<?php
	require($_SERVER["DOCUMENT_ROOT"] . '/include/footer.php');
?>
