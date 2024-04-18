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

	// Check if session is still open
	if (SessionRepository::getState($_SESSION["session"]) == 0) {
		header("Location: /sessionend");
	}

	// If session is not paused
	$styleBox = "style='display: block'";
	$styleTitle = "style='display: none'";
	if (SessionRepository::getState($_SESSION["session"]) == 2) {
		$styleBox = "style='display: none'";
		$styleTitle = "style='display: block'";
	}
?>

<link rel="stylesheet" href="/public/css/sessionpanel.css">

<form method="post" id="formupdate">
	<input type="hidden" name="chapter" value="0" id="chapter">
	<input type="hidden" name="status" value="0" id="status">
</form>

<div id="statusBoxPaused" <?= $styleTitle ?>>
	<h2><?= lang("SESSION_PAUSED") ?></h2>
</div>

<div class="mainbox statusBox" id="statusBox" <?= $styleBox ?>>
	<table>
		<thead>
			<tr>
				<th>Chapitre</th>
				<th>Action</th>
				<th>Status</th>
			</tr>
		</thead>
		<tbody>
			<?php
				foreach (SessionRepository::getChapter($_SESSION["session"]) as $chapter) { ?>
				<tr>
					<td class="col1"><?= $chapter["title"] ?></td>
					<td class="col2">
						<input type="hidden" name="liste" value="<?php echo $chapter['id']; ?>">
						<button class="button" onclick="setStatus(<?=$chapter['id']?>,1)"><i class="ri-error-warning-line"></i>J'ai besoin d'aide !</button>
						<button class="button" onclick="setStatus(<?=$chapter['id']?>,2)"><i class="ri-edit-line"></i> Travail en cours...</button>
						<button class="button" onclick="setStatus(<?=$chapter['id']?>,3)"><i class="ri-thumb-up-line"></i> Terminé !</button>
					</td>
					<td class="col3"><?= SessionRepository::getStatus($chapter['id'], UserRepository::getId($_SESSION["login"])) ?></td>
				</tr>
			<?php
				}
			?>
		</tbody>
	</table>
</div>

<?php
	// LS-Link
	if (UserRepository::getLink($_SESSION["login"], $_SESSION["session"])){
		echo "LS-LINK n°" . UserRepository::getLink($_SESSION["login"], $_SESSION["session"]);
	}
	echo "<br>LS-LINK : <form method='POST'><input type='hidden' name='sessionId' value='" . $_SESSION["session"] . "'><input type='number' name='number'/><input type='submit' name='link'/></form>";
?>

<button id="shareButton">Start screenshare</button>
<div id="screenshare"></div>

<!-- Create "global" varaibles -->
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
