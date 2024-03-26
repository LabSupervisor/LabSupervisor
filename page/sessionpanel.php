<?php
	// Import header
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_header.php");
	mainHeader("Session en cours");

	// Ask for permissions
	permissionChecker(true, array(STUDENT));

	// Logic
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/updateStatus.php");
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/createLink.php");

	// Check if session is still open
	if (!SessionRepository::isActive(SessionRepository::getName($_SESSION["session"]))) {
		header("Location: /sessionend");
	}
?>

<script src="/public/js/ft_updateStatus.js"></script>

<h2>Modifier votre Statut </h2>

<form method="post" id="formupdate">
	<input type="hidden" name="chapter" value="0" id="chapter">
	<input type="hidden" name="status" value="0" id="status">
</form>

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
				<td>
					<?php echo $chapter["title"]; ?>
				</td>
				<td>
					<input type="hidden" name="liste" value="<?php echo $chapter['id']; ?>">
					<button onclick="setStatus(<?=$chapter['id']?>,3)">Terminé !</button>
					<button onclick="setStatus(<?=$chapter['id']?>,2)">Travail en cours...</button>
					<button onclick="setStatus(<?=$chapter['id']?>,1)">J'ai besoin d'aide !</button>
				</td>
				<td>
					<?php
						echo SessionRepository::getStatus($chapter['id'], UserRepository::getId($_SESSION["login"]));
					?>
				</td>
			</tr>
		<?php
			}
		?>

	</tbody>
</table>

<?php
	// LS-Link
	if (UserRepository::getLink($_SESSION["login"], $_SESSION["session"])){
		echo "LS-LINK n°" . UserRepository::getLink($_SESSION["login"], $_SESSION["session"]);
	}
	echo "<br>LS-LINK : <form method='POST'><input type='hidden' name='sessionId' value='" . $_SESSION["session"] . "'><input type='number' name='number'/><input type='submit' name='link'/></form>";
?>

<button id="shareButton">Partager</button>

<!-- Create "global" varaibles -->
<script>
	var userId = <?= UserRepository::getId($_SESSION["login"]) ?>;
	var sessionId = <?= $_SESSION["session"] ?>;
</script>

<!-- Import PeerJS server -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/peerjs/1.5.2/peerjs.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.7.4/socket.io.js"></script>

<!-- Import screenshare engine -->
<script src="/public/js/clientScreenshare.js"></script>

<!-- Import is session active check -->
<script src="/public/js/sessionActiveCheck.js"></script>

<?php
	require($_SERVER["DOCUMENT_ROOT"] . '/logic/ft_footer.php');
?>
