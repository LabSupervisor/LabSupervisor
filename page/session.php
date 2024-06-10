<?php

	use
		LabSupervisor\app\repository\SessionRepository,
		LabSupervisor\app\repository\UserRepository;
	use function
		LabSupervisor\functions\mainHeader,
		LabSupervisor\functions\lang,
		LabSupervisor\functions\nameFormat;

	if (isset($_COOKIE["notification"])) {
		$notification = $_COOKIE["notification"];
		unset($_COOKIE["notification"]);
		setcookie("notification", "", time()-100);
	}

	// Logic
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/joinSession.php");

	// Import header
	mainHeader(lang("NAVBAR_SESSION"), true);
?>

<link rel="stylesheet" href="/public/css/session.css">

<?php
	$roleList = UserRepository::getRole($_SESSION["login"]);
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

	if (!isset($_GET["page"])) {
		$_GET["page"] = 1;
	}

	if (count($sessionList) > 0) {
?>

<div class="mainbox maintable">
	<table>
		<thead>
			<tr class="thead">
				<th><?= lang("SESSION_SUBJECT") ?></th>
				<th><?= lang("SESSION_DESCRIPTION") ?></th>
				<th><?= lang("SESSION_TEACHER") ?></th>
				<th><?= lang("SESSION_DATE") ?></th>
				<th><i class="ri-group-line"></i></th>
				<th><?= lang("SESSION_STATE") ?></th>
			</tr>
		</thead>
		<tbody>
			<?php
				$j = 0;
				$max = 5;
				for($i = 0; $i < count($sessionList); $i++) {
					if ($j >= ($_GET["page"] -1) * $max && $j < $_GET["page"] * $max) {
						echo "<tr>";
						foreach($sessionList[$i] as $line) {
							if ($line["state"] == 0) {
								$stateText = "<i class='ri-door-closed-line'></i> " . lang("SESSION_CLOSE");
							} else {
								$stateText = "<i class='ri-door-open-line'></i> " . lang("SESSION_OPEN");
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

							$nbParticipantActive = 0;
							foreach (SessionRepository::getParticipants($line["id"]) as $value) {
								if (UserRepository::isActive($value["iduser"]) == true) {
									$nbParticipantActive = $nbParticipantActive +1 ;
								}
							}

							echo '<td>' . $nbParticipantActive-1 . "</td>";
							echo '<td class="colState">' . $stateText . '</td>';
							if (!in_array(ADMIN, $roleList)) {
								echo "<td class='col5'>";

								// Display modify button to teachers
								if (in_array(TEACHER, $roleList)) {
									echo "<form method='POST' action='/sessionmodifier'><input type='hidden' name='sessionId' value='" . $line["id"] . "'><button type='submit' class='button' title='" . lang("SESSION_UPDATE") . "'><i class=\"ri-pencil-line\"></i></button></form>";
								}

								// Only select active session
								if ($line["state"] != 0 ) {
									echo "<form method='POST'><button type='submit' name='connect[" . $line["id"] . "]' value='" . lang("SESSION_STATE_OPEN") . "' class='button'><i class=\"ri-login-box-line\"></i> " . lang("SESSION_STATE_OPEN") . "</button></form>";
								} else {
									echo "<form method='POST'><button type='submit' name='connect[" . $line["id"] . "]' value='" . lang("SESSION_STATE_OPEN") . "' class='button'><i class=\"ri-login-box-line\"></i> " . lang("SESSION_STATE_CONSULT") . "</button></form>";
								}

								echo "</td>";
							}
						}
						echo "</tr>";
					}
					$j++;
				}
			?>
		</tbody>
	</table>
	<form class="pageGroup" method="GET" onsubmit="loading()">
		<?php
			$pages = ceil(count($sessionList)/$max);

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
		<input class="pageNumber" id="pageNumber" type="number" onKeyUp="validatePageNumber(this, <?= $pages ?>)" value="<?= $_GET["page"] ?>" min="1" max="<?= $pages ?>">
		<?php
			if (count($sessionList) > $_GET["page"] * $max) {
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

<script src="/public/js/pageSelector.js"></script>
<script src="/public/js/function/popup.js"></script>
<script src="/public/js/function/loading.js"></script>
<script src="/public/js/function/validatePage.js"></script>

<?php
	} else {
		echo "<div class='singleErrorContainer'><a class='singleErrorTitle'>" . lang("SESSION_EMPTY") . "</a></div>";
	}

	if (isset($notification)) {
		echo '<script> popupDisplay("' . $notification . '"); </script>';
	}

	require($_SERVER["DOCUMENT_ROOT"] . '/include/footer.php');
?>
