<?php

	use LabSupervisor\app\repository\SessionRepository;
	use LabSupervisor\app\repository\UserRepository;
	use function LabSupervisor\functions\mainHeader;
	use function LabSupervisor\functions\lang;
	use function LabSupervisor\functions\permissionChecker;
	use function LabSupervisor\functions\statusFormat;

	// Import header
	mainHeader(lang("DASHBOARD_TITLE"));

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
			<a class="button" href="/sessions">Retour</a>
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
	setInterval(() => {
		var participantList = [];
		var chapterList = [];

		<?php foreach (SessionRepository::getParticipant($_SESSION["session"]) as $value) { ?>
			participantList.push(<?= $value["iduser"] ?>);
		<?php } ?>

		<?php foreach (SessionRepository::getChapter($_SESSION["session"]) as $value) { ?>
			chapterList.push(<?= $value["id"] ?>);
		<?php } ?>

		participantList.forEach((userId, index) => {
			chapterList.forEach((chapterId, index) => {
				fetch("/connect", {
					method: 'post',
					headers: {
					'Accept': 'application/json',
					'Content-Type': 'application/json'
					},
					body: JSON.stringify({
						"ask": "get_status",
						"idUser": userId,
						"idChapter": chapterId
					})
				}).then((response) => {
					return response.json()
				}).then((res) => {
					statusUpdate(document.getElementById(userId + "_" + chapterId), res.Response.Status)
				}).catch((error) => {
					console.log(error)
				})
			})
		});

		function statusUpdate(DOMElement, statusId) {
			let status = "";
			let text = "<?= lang("DASHBOARD_STATUS_WAITING") ?>";
			if (statusId == 0) {
				status = "";
			}
			if (statusId == 1) {
				status = "statusRed";
				text = "<?= lang("DASHBOARD_STATUS_RED") ?>";
			}
			if (statusId == 2) {
				status = "statusYellow";
				text = "<?= lang("DASHBOARD_STATUS_YELLOW") ?>";
			}
			if (statusId == 3) {
				status = "statusGreen";
				text = "<?= lang("DASHBOARD_STATUS_GREEN") ?>";
			}

			DOMElement.className = "statusBall " + status
			DOMElement.innerHTML = "<a>" + text + "</a>"
		}
	}, 3000);
</script>

<button id="getScreenshare">Get screenshare</button>
<div id="screenshare"></div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/peerjs/1.5.2/peerjs.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.7.4/socket.io.js"></script>
<script src="/public/js/viewerScreenshare.js"></script>

<?php
	require($_SERVER["DOCUMENT_ROOT"] . '/include/footer.php');
?>
