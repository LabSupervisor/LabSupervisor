<?php
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_header.php");
	mainHeader("Log");
?>

<?php
	permissionChecker(true, false, false, true);
?>

<?php
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_getDBLog.php");
?>

<link rel="stylesheet" href="../public/css/log.css">

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
				$userInfo = UserRepository::getInfo(UserRepository::getEmail($line["iduser"]));
				$username = $userInfo["name"] . " " . $userInfo["surname"];

				echo "<tr>";
				echo '<td class="col1">' . $line["id"] . '</td>';
				echo '<td class="col2">' . $username . '</td>';
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
		$fileDate = date("Y-m-d");
	} else {
		$fileDate = $_GET["date"];
	}

	$file = $_SERVER["DOCUMENT_ROOT"] . "/logs/" . $fileDate . ".log";
	if (file_exists($file)) {
		$logs = file_get_contents($file);
?>

<div class="table-container2">
	<table>
		<thead>
			<tr>
				<th class="col-1">Erreur</th>
				<th class="col-2">Message</th>
				<th class="col-3">Heure</th>
			</tr>
		</thead>
		<tbody-wrapper>
			<tbody>
			<?php
				$listDate = array();
				$temp = explode("\n", $logs);
				foreach($temp as $value) {
					if (preg_match("/\[" . $fileDate . " (.*?)\]/", $value, $matches)) {
						array_push($listDate, $matches[1]);
					}
				}

				$log = preg_split("/\[" . $fileDate . " (.*?)\]/", $logs);

				$i = -1;
				foreach($log as $temp) {
					$message = "";
					$error = "";

					$data = explode("\n", $temp);
					foreach($data as $value) {
						if (!str_starts_with($value, "#")) {
							if (strlen($value) > 1) {
								$error = $value;
							}
						} else {
							$message .= $value . " ";
						}
					}

					if (strlen($error) > 1) {
						echo "<tr>";
						echo "<td class='col-1'>" . $error . "</td>";
						echo "<td class='col-2-container'>";
						echo '<div class="col-2-tooltip">' . htmlspecialchars(str_replace("##", "#", $message)) . '</div>';
						echo '<div class="col-2">' . str_replace("##", "#", $message) . '</div>';
						echo "</td>";
						echo "<td class='col-3'>" . $listDate[$i] . "</td>";
						echo "</tr>";
					}
					$i++;
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
