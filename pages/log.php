<?php
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_header.php");
	mainHeader("Log");
?>

<?php
	permissionChecker(true, false, false, true);
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
			<a href="/log?trace">
				<button><i class="ri-draft-line"></i> Trace</button>
			</a>
			<a href="/log?error">
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
	<div class="table-container2">
		<table>
			<thead>
				<tr>
					<th class="col-1">Erreur</th>
					<th class="col-2">Message</th>
					<th class="col-3">Date</th>
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
					echo "<td class='col-1'>" . $error . "</td>";
					echo "<td class='col-2-container'>";
					echo '<div class="col-2-tooltip">' . htmlspecialchars($message) . '</div>';
					echo '<div class="col-2">' . $message . '</div>';
					echo "</td>";
					echo "<td class='col-3'>" . $date . "</td>";
					echo "</tr>";
				}
				?>
			</tbody>
			</tbody-wrapper>
		</table>
	</div>

		<div class="button-container2">
			<div class="left-buttons2">
			<a href="/log?trace">
				<button><i class="ri-draft-line"></i> Trace</button>
			</a>
			<a href="/log?error">
				<button><i class="ri-error-warning-line"></i> Erreur</button>
			</a>
			</div>
			<div class="right-buttons2">
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

	<div class="button-container2">
		<div class="left-buttons2">
		<a href="/log?trace">
			<button><i class="ri-draft-line"></i> Trace</button>
		</a>
		<a href="/log?error">
			<button><i class="ri-error-warning-line"></i> Erreur</button>
		</a>
		</div>
		<div class="right-buttons2">
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
