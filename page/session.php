<?php

	use LabSupervisor\app\repository\SessionRepository;
	use function
		LabSupervisor\functions\mainHeader,
		LabSupervisor\functions\lang,
		LabSupervisor\functions\permissionChecker,
		LabSupervisor\functions\nameFormat;

	// Import header
	mainHeader(lang("NAVBAR_SESSION"), true);

	// Ask for permissions and store it
	$roleList = permissionChecker(true, array(ADMIN, STUDENT, TEACHER));

	// Logic
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/joinSession.php");
?>

<link rel="stylesheet" href="/public/css/session.css">

<?php
	$sessionList = array();
	// Get all sessions for admin
	if (in_array(ADMIN, $roleList)) {
		$session = SessionRepository::getSessions();

		foreach($session as $value => $key) {
			array_push($sessionList, SessionRepository::getInfo($key["id"]));
		}
	// Get user's session
	} else {
		$session = SessionRepository::getUserSessions($_SESSION["login"]);

		foreach($session as $value => $key) {
			array_push($sessionList, SessionRepository::getInfo($key["idsession"]));
		}
	}

	if (count($sessionList) > 0) {
?>

<?php
	if (in_array(TEACHER, $roleList)) {
?>

<div class="mainbox buttonContainer">
	<a href="/sessioncreation">
		<button class="button" ><i class="ri-computer-line"></i> <?= lang("NAVBAR_CREATE_SESSION") ?></button>
	</a>
</div>

<?php
	}
?>

<div class="mainbox maintable">
	<table>
		<thead>
			<tr class="thead">
				<th><?= lang("SESSION_SUBJECT") ?></th>
				<th><?= lang("SESSION_DESCRIPTION") ?></th>
				<th><?= lang("SESSION_TEACHER") ?></th>
				<th><?= lang("SESSION_DATE") ?></th>
				<th><?= lang("SESSION_STATE") ?></th>
				<?php
					if (!in_array(ADMIN, $roleList)) {
						echo "<th>" . lang("SESSION_ACTION") . "</th>";
					}
				?>
			</tr>
		</thead>
		<tbody>
			<?php
				for($i = 0; $i < count($sessionList); $i++) {
					echo "<tr>";
					foreach($sessionList[$i] as $line) {
						if ($line["state"] == 0) {
							$buttonStyle = "statusRed";
						} else {
							$buttonStyle = "statusGreen";
						}

						$creatorName = nameFormat($line["idcreator"], false);

						echo '<td class="col1" title="' . htmlspecialchars($line["title"]) . '">'. htmlspecialchars($line["title"]) ."</td>";

						if ($line["description"])
							$description = htmlspecialchars($line["description"]);
						else
							$description = lang("SESSION_DESCRIPTION_EMPTY");
						echo '<td class="col2" title="' . $description . '"><div class="col2">'. $description . "</div></td>";

						echo '<td class="col3">' . htmlspecialchars($creatorName) . "</td>";
						echo '<td class="col4">' . date("d/m/Y H:i", strtotime($line["date"])) . "</td>";
						echo '<td class="colState"><div class="statusBall ' . $buttonStyle . '"</div></td>';
						if (!in_array(ADMIN, $roleList)) {
							echo "<td class='col5'>";

							// Display modify button to teachers
							if (in_array(TEACHER, $roleList)) {
								echo "<form method='POST' action='/sessionmodifier'><input type='hidden' name='sessionId' value='" . $line["id"] . "'><button type='submit' class='button'><i class=\"ri-pencil-line\"></i> " . lang("SESSION_UPDATE") . "</button></form>";
							}

							// Only select active session
							if ($line["state"] != 0 || in_array(TEACHER, $roleList)) {
								echo "<form method='POST'><button type='submit' name='connect[" . $line["id"] . "]' value='" . lang("SESSION_STATE_OPEN") . "' class='button'><i class=\"ri-login-box-line\"></i> " . lang("SESSION_STATE_OPEN") . "</button></form>";
							} else {
								echo '<i class="ri-door-closed-line"></i> ' . lang("SESSION_ACTION_END");
							}

							echo "</td>";
						}
					}
					echo "</tr>";
				}
			?>
		</tbody>
	</table>
</div>

<?php
	} else {
		echo "<div class='nosessionmain'><div class='nosessioncontent'><a class='nosessiontitle'>" . lang("SESSION_EMPTY") . "</a></div></div>";
	}

	require($_SERVER["DOCUMENT_ROOT"] . '/include/footer.php');
?>
