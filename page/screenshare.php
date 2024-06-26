<?php

	use LabSupervisor\app\repository\UserRepository;
	use function
		LabSupervisor\functions\mainHeader,
		LabSupervisor\functions\lang;

?>

<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8">
	</head>
	<body>
		<link rel="stylesheet" href="/public/css/screenshare.css">

		<?php
			if (!isset($_GET["userId"]) || $_GET["userId"] <= 0) {
				echo "<script> window.open('','_self').close(); </script>";
			}

			mainHeader(UserRepository::getInfo($_GET["userId"])["name"] . " " . UserRepository::getInfo($_GET["userId"])["surname"], false);
		?>

		<script>
			var requestId = <?= $_GET["userId"] ?>;
		</script>

		<div id="firefoxButton" class="firefoxButton" style="display: none;">
			<h2><?= lang("DASHBOARD_SCREENSHARE") ?></h2>
			<button class="button" onclick="startScrenshare()"><?= lang("DASHBOARD_SCREENSHARE_OPEN") ?></button>
		</div>

		<div id="screenshare"></div>

		<!-- Import PeerJS server -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/peerjs/1.5.2/peerjs.min.js"></script>

		<script>
			var idSession = <?= $_SESSION["session"] ?>;
		</script>

		<!-- Import screenshare engine -->
		<script src="/public/js/viewerScreenshare.js"></script>
	</body>
</html>
