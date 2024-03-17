<?php
	// Import header
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_header.php");
	mainHeader(lang("DASHBOARD_TITLE"));

	// Ask for permissions
	permissionChecker(true, array(TEACHER));

	// Logic
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_statusFormat.php");
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/endSession.php");

	// Check if session is still open
	if (!SessionRepository::isActive(SessionRepository::getName($_SESSION["session"]))) {
		header("Location: /denied");
	}
?>

<link rel="stylesheet" href="/public/css/dashboard.css">

<div class="mainbox button-container">
	<form method="POST">
		<input type="hidden" name="sessionId" value="<?= $_SESSION["session"] ?>">
		<input class="button" type="submit" name="modify" value="<?= lang("SESSION_UPDATE") ?>">
		<input class="button" type="submit" name="close" value="<?= lang("DASHBOARD_SESSION_END") ?>">
	</form>
</div>

<div class="mainbox table-container">
	<table>
		<thead>
			<tr class="thead">
				<th><?= lang("DASHBOARD_STUDENT_NAME") ?></th>
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
				echo "<td class='col1'>" . $participantName["name"] . " " . $participantName["surname"] . "</td>";
				echo "<td class='col2'>" . $chapterList . "</td>";
				echo "<td class='col3'>" . $statusList . "</td>";
				echo "</tr>";
			}
		?>
		</tbody>
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
						"ask": "get_state",
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
			let text = "";
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
