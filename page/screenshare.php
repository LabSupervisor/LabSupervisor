<?php

	use LabSupervisor\app\repository\UserRepository;
	use function
		LabSupervisor\functions\mainHeader,
		LabSupervisor\functions\permissionChecker;

	// Ask for permissions
	permissionChecker(true, array(TEACHER));
?>

<link rel="stylesheet" href="/public/css/screenshare.css">

<?php
	if (!isset($_GET["userId"])) {
?>
		<style>
			* {
				background-color: black;
				color: white;
				user-select: none;
			}
		</style>

		<div class="errormain">
			<div class="errorcontent">
				<a class="errortitle">Invalid request.</a>
			</div>
		</div>
<?php
		return;
	}

	mainHeader(UserRepository::getInfo(UserRepository::getEmail($_GET["userId"]))["name"] . " " . UserRepository::getInfo(UserRepository::getEmail($_GET["userId"]))["surname"], false);
?>

<script>
	var requestId = <?= $_GET["userId"] ?>;
	var videoServerHost = "<?= $_ENV["VIDEO_SERVER_HOST"] ?>";
	var videoServerPort = <?= $_ENV["VIDEO_SERVER_PORT"] ?>;
</script>

<div id="screenshare"></div>

<!-- Import PeerJS server -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/peerjs/1.5.2/peerjs.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.7.4/socket.io.js"></script>

<!-- Import screenshare engine -->
<script src="/public/js/viewerScreenshare.js"></script>
