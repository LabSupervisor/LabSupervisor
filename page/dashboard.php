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
					$statusList .= statusFormat(SessionRepository::getStatus(SessionRepository::getChapterId($value["title"]), $userId));

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
