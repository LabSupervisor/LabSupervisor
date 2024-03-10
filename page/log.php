<?php
	// Import header
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_header.php");
	mainHeader("Log");

	// Ask for permissions
	permissionChecker(true, array(admin));
?>

<link rel="stylesheet" href="/public/css/log.css">

<?php
	// If traces are ask
	if (isset($_GET["trace"])) {
?>
<div class="mainbox table-container">
	<table>
		<thead>
			<tr class="thead">
				<th><?= lang("LOG_TRACE_ID") ?></th>
				<th><?= lang("LOG_TRACE_USER") ?></th>
				<th><?= lang("LOG_TRACE_MESSAGE") ?></th>
				<th><?= lang("LOG_TRACE_DATE") ?></th>
			</tr>
		</thead>
		<tbody>
			<?php
			$logs = LogRepository::getLogs();

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
<div class="mainbox button-container">
	<a class="button2" href="/logs?trace"><i class="ri-draft-line"></i> <?= lang("LOG_TRACE") ?></a>
	<a class="button2" href="/logs?error"><i class="ri-error-warning-line"></i> <?= lang("LOG_ERROR") ?></a>
</div>
<?php
// If errors are ask
} else if (isset($_GET["error"])) {
	// Select current date if no one is given: default value
	if (!isset($_GET["date"])) {
		$fileDate = date("Y-m-d");
	} else {
		$fileDate = $_GET["date"];
	}

	// Get errors file
	$file = $_SERVER["DOCUMENT_ROOT"] . "/log/" . $fileDate . ".log";
	if (file_exists($file)) {
		$logs = file_get_contents($file);
?>

<div class="mainbox table-container">
	<table>
		<thead>
			<tr class="thead">
				<th class="col-1"><?= lang("LOG_ERROR_ERROR") ?></th>
				<th class="col-2"><?= lang("LOG_ERROR_MESSAGE") ?></th>
				<th class="col-3"><?= lang("LOG_ERROR_DATE") ?></th>
			</tr>
		</thead>
		<tbody>
		<?php
			// Get dates
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
				// Get error's values
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

				// Prevent showing empty line
				if (strlen($error) > 1) {
					echo "<tr>";

					echo "<td class='col3-container'>";
					echo '<div class="col3-tooltip">' . htmlspecialchars($message) . '</div>';
					echo "<div class='col3'>" . htmlspecialchars($error) . "</div>";

					echo "<td class='col3-container'>";
					echo '<div class="col3-tooltip">' . htmlspecialchars(str_replace("##", "#", $message)) . '</div>';
					echo '<div class="col3">' . str_replace("##", "#", htmlspecialchars($message)) . '</div>';

					echo "</td>";
					echo "<td class='col3'>" . $listDate[$i] . "</td>";
					echo "</tr>";
				}
				$i++;
			}
		?>
		</tbody>
	</table>
</div>

	<?php
	} else {
		echo lang("LOG_ERROR_FILENOTFOUND");
	}
	?>

	<div class="mainbox button-container">
		<a class="button2" href="/logs?trace"><i class="ri-draft-line"></i> <?= lang("LOG_TRACE") ?></a>
		<a class="button2" href="/logs?error"><i class="ri-error-warning-line"></i> <?= lang("LOG_ERROR") ?></a>
		<form method="get">
			<input type="hidden" name="error">
			<input type="date" id="date" name="date" value="<?= $fileDate ?>">
			<input class="button" type="submit" value="<?= lang("LOG_ERROR_SUBMIT") ?>">
		</form>
	</div>

<?php
}
?>
