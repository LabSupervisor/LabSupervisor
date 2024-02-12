<?php
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_header.php");
	mainHeader("Log");
?>

<link rel="stylesheet" href="../public/css/log.css">

<?php
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_getDBLog.php");
?>

<?php
	if (isset($_GET["trace"])) {
?>
	<div class="table-container">
		<table>
			<thead>
				<tr>
					<th class="col1">ID</th>
					<th class="col2">Utilisateur</th>
					<th class="col3">Message</th>
					<th class="col4">Date</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$logs = getDBLog();

				foreach ($logs as $line) {
					echo "<tr>";
					echo '<td class="col1">' . $line["id"] . '</td>';
					echo '<td class="col2">' . getName($line["iduser"]) . '</td>';
					echo '<td class="col3-container">';
					echo '<div class="col3-tooltip">' . htmlspecialchars($line["message"]) . '</div>';
					echo '<div class="col3">' . $line["message"] . '</div>';
					echo '</td>';
					echo '<td class="col4">' . $line["date"] . '</td>';
					echo "</tr>";
				}
				?>
			</tbody>
		</table>
	</div>
	<div class="button-container">
			<a href="<?= "http://" . $_SERVER["SERVER_NAME"] . "/pages/log.php?trace" ?>">
				<button><i class="ri-draft-line"></i> Trace</button>
			</a>
			<a href="<?= "http://" . $_SERVER["SERVER_NAME"] . "/pages/log.php?error" ?>">
				<button><i class="ri-error-warning-line"></i> Erreur</button>
			</a>
	</div>
<?php
} else if (isset($_GET["error"])) {
	if (!isset($_GET["date"])) {
		$date = date("Y-m-d");
	} else {
		$date = $_GET["date"];
	}

	$file = $_SERVER["DOCUMENT_ROOT"] . "/logs/" . $date . ".log";
	if (file_exists($file)) {
		$logs = file_get_contents($file);
		$logs = explode("\n", $logs);
?>
		<table>
			<thead>
				<tr>
					<th>Erreur</th>
					<th>Message</th>
					<th>Date</th>
				</tr>
			</thead>
			<tbody-wrapper>
			<tbody>
				<?php
				foreach ($logs as $line) {
					$date = "";
					$error = "";
					$message = "";
					$datePattern = "/\[(.*?)\]/";
					$errorPattern = "/\](.*?)\:/";
					$messagePattern = "/: (.*)$/";

					if (preg_match($datePattern, $line, $matches))
						$date = $matches[1];
					if (preg_match($errorPattern, $line, $matches))
						$error = $matches[1];
					if (preg_match($messagePattern, $line, $matches))
						$message = $matches[1];

					echo "<tr>";
					echo "<td class='col1'>" . $error . "</td>";
					echo "<td class='col3-container'>";
					echo '<div class="col3-tooltip">' . htmlspecialchars($message) . '</div>';
					echo '<div class="col3">' . $message . '</div>';
					echo "</td>";
					echo "<td class='col2'>" . $date . "</td>";
					echo "</tr>";
				}
				?>
			</tbody>
			</tbody-wrapper>
		</table>

		<div class="button-container">
			<a href="<?= "http://" . $_SERVER["SERVER_NAME"] . "/pages/log.php?trace" ?>">
				<button><i class="ri-draft-line"></i> Trace</button>
			</a>
			<a href="<?= "http://" . $_SERVER["SERVER_NAME"] . "/pages/log.php?error" ?>">
				<button><i class="ri-error-warning-line"></i> Erreur</button>
			</a>
			<div class="right-buttons">
				<form method="get">
					<input type="hidden" name="error">
					<input type="date" name="date">
					<input type="submit" value="Envoyer">
				</form>
			</div>
		</div>

		<?php
	} else {
		echo "Fichier introuvable"; ?>

		<div class="button-container">
		<a href="<?= "http://" . $_SERVER["SERVER_NAME"] . "/pages/log.php?trace" ?>">
			<button><i class="ri-draft-line"></i> Trace</button>
		</a>
		<a href="<?= "http://" . $_SERVER["SERVER_NAME"] . "/pages/log.php?error" ?>">
			<button><i class="ri-error-warning-line"></i> Erreur</button>
		</a>
		<div class="right-buttons">
			<form method="get">
				<input type="hidden" name="error">
				<input type="date" name="date">
				<input type="submit" value="Envoyer">
			</form>
		</div>
	</div>
<?php
	}
}
?>
