<?php

	use
		LabSupervisor\app\repository\UserRepository,
		LabSupervisor\app\repository\SessionRepository;
	use function
		LabSupervisor\functions\mainHeader,
		LabSupervisor\functions\lang,
		LabSupervisor\functions\permissionChecker;

	// Import header
	mainHeader("Session en cours", true);

	// Ask for permissions
	permissionChecker(true, array(STUDENT));

	// Logic
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/updateStatus.php");
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/createLink.php");

	// If session is not paused
	$styleBox = "style='display: block'";
	$styleTitle = "style='display: none'";
	$styleState = "style='display: none'";
	$styleMain = "style='display: block'";
	if (SessionRepository::getState($_SESSION["session"]) != 0) {
		if (SessionRepository::getState($_SESSION["session"]) == 2) {
			$styleBox = "style='display: none'";
			$styleTitle = "style='display: block'";
		}
	} else {
		$styleState = "style='display: block'";
		$styleMain = "style='display: none'";
	}
?>

<link rel="stylesheet" href="/public/css/sessionpanel.css">
<link rel="stylesheet" href="/public/css/error.css">

<div id="sessionState" class="errormain" <?= $styleState ?>>
	<div class="errorcontent">
		<a class="errortitle"><?= lang("SESSION_END") ?></a>
		<br>
		<a class="errorsubtitle"><?= lang("SESSION_END_MESSAGE") ?></a>
		<br>
		<a href="/sessions">
			<button class="button"><?= lang("SESSION_END_BACK") ?></button>
		</a>
	</div>
</div>

<div id="sessionMain" <?= $styleMain ?>>
	<div class="mainbox maintable">
		<div class="sessionTitle">
			<a class="back" href="/sessions"><i class="ri-arrow-left-line"></i> <?= lang("DASHBOARD_BACK") ?></a>
			<div>
				<h2><?= SessionRepository::getName($_SESSION["session"]) ?></h2>
				<a><?= SessionRepository::getInfo($_SESSION["session"])[0]["description"] ?></a>
			</div>
		</div>

		<div id="statusBoxPaused" <?= $styleTitle ?>>
			<h2><?= lang("SESSION_PANEL_PAUSED") ?></h2>
		</div>

		<div id="statusBox" <?= $styleBox ?>>
			<table>
				<thead>
					<tr>
						<th><?= lang("SESSION_PANEL_CHAPTER") ?></th>
						<th><?= lang("SESSION_PANEL_ACTION") ?></th>
						<th><?= lang("SESSION_PANEL_STATUS") ?></th>
					</tr>
				</thead>
				<tbody>
					<?php
						foreach (SessionRepository::getChapter($_SESSION["session"]) as $chapter) {

							$statusBall = "statusBall";
							switch (SessionRepository::getStatus($chapter['id'], $_SESSION["login"])) {
								case "1":
									$statusBall = "statusBall statusRed";
									break;
								case "2":
									$statusBall = "statusBall statusYellow";
									break;
								case "3":
									$statusBall = "statusBall statusGreen";
									break;
							}
					?>
						<tr>
							<td class="col1"><?= $chapter["title"] ?></td>
							<td class="col2">
								<input type="hidden" name="liste" value="<?php echo $chapter['id']; ?>">
								<button class="button" onclick="setStatus(<?= $chapter['id'] ?>, 1)"><i class="ri-error-warning-line"></i> <?= lang("SESSION_PANEL_HELP") ?></button>
								<button class="button" onclick="setStatus(<?= $chapter['id'] ?>, 2)"><i class="ri-edit-line"></i> <?= lang("SESSION_PANEL_WIP") ?></button>
								<button class="button" onclick="setStatus(<?= $chapter['id'] ?>, 3)"><i class="ri-thumb-up-line"></i> <?= lang("SESSION_PANEL_DONE") ?></button>
							</td>
							<td class="col3"><div class="<?= $statusBall ?>" id="statusBall_<?= $chapter['id'] ?>"></div></td>
						</tr>
					<?php
						}
					?>
				</tbody>
			</table>
		</div>
	</div>

	<div class="item">
		<div class="mainbox screenshareBox">
			<h2><?= lang("SESSION_PANEL_SCREENSHARE") ?></h2>
			<button class="button" id="shareButton"><i class="ri-share-line"></i> <?= lang("SESSION_PANEL_SCREENSHARE_START") ?></button>
		</div>

		<div class="mainbox lslinkBox">
			<h2><?= lang("SESSION_PANEL_LSLINK") ?></h2>

			<?php
				$buttonText = '<i class="ri-link"></i> ' . lang("SESSION_PANEL_LSLINK_CONNECT");
				$unlinkButton = "";
				$linkId = "";
				if (UserRepository::getLink($_SESSION["login"], $_SESSION["session"])) {
					$linkId = UserRepository::getLink($_SESSION["login"], $_SESSION["session"]);

					echo lang("SESSION_PANEL_LSLINK_NUMBER") . $linkId;
					$buttonText = '<i class="ri-pencil-line"></i> ' . lang("SESSION_PANEL_LSLINK_MODIFY");
					$unlinkButton = "<button class='button' type='submit' name='disconnect' value=" . $linkId . "><i class=\"ri-dislike-line\"></i> " . lang("SESSION_PANEL_LSLINK_DISCONNECT") . "</button>";
				}
				echo "<div class='lslinkButton'><form method='POST'>";
				echo "<input type='hidden' name='sessionId' value='" . $_SESSION["session"] . "'>";
				echo "<input class='lslinkid' type='number' name='number' value='" . $linkId. "'>";
				echo "<button class='button' type='submit' name='link'>" . $buttonText . "</button>";
				echo "</form>";

				echo"<form method='POST'>";
				echo $unlinkButton;
				echo"</form></div>";
			?>
		</div>
	</div>
</div>

<!-- Create "global" variables -->
<script>
	var sessionId = <?= $_SESSION["session"] ?>;
	var videoServerHost = "<?= $_ENV["VIDEO_SERVER_HOST"] ?>";
	var videoServerPort = <?= $_ENV["VIDEO_SERVER_PORT"] ?>;
</script>

<script src="/public/js/ft_updateStatus.js"></script>

<!-- Import PeerJS server -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/peerjs/1.5.2/peerjs.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.7.4/socket.io.js"></script>

<!-- Import screenshare engine -->
<script src="/public/js/clientScreenshare.js"></script>

<!-- Import is session active check -->
<script src="/public/js/sessionGetState.js"></script>

<?php
	require($_SERVER["DOCUMENT_ROOT"] . '/include/footer.php');
?>
