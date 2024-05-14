<?php

	use
		LabSupervisor\app\repository\UserRepository,
		LabSupervisor\app\repository\LogRepository;
	use function
		LabSupervisor\functions\mainHeader,
		LabSupervisor\functions\lang;

	// Import header
	mainHeader(lang("NAVBAR_LOG"), true);

?>

<link rel="stylesheet" href="/public/css/log.css">

<?php
	if (!isset($_GET["trace"]) && !isset($_GET["error"])) {
		$_GET["trace"] = "true";
	}

	// If traces are ask
	if (isset($_GET["trace"])) {
?>

<div class="mainbox buttonContainer">
	<a href="/logs?trace">
		<button class="button"><i class="ri-draft-line"></i> <?= lang("LOG_TRACE") ?></button>
	</a>
	<a href="/logs?error">
		<button class="button"><i class="ri-error-warning-line"></i> <?= lang("LOG_ERROR") ?></button>
	</a>
</div>

<div class="mainbox maintable">
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
			if (!isset($_GET["page"])) {
				$_GET["page"] = 1;
			}

			$i = 0;
			$max = 20;
			foreach (LogRepository::getLogs() as $line) {
				if ($i >= ($_GET["page"] -1) * $max && $i < $_GET["page"] * $max) {
					$userInfo = UserRepository::getInfo($line["iduser"]);
					$username = $userInfo["name"] . " " . $userInfo["surname"];

					echo "<tr>";
					echo '<td>' . $line["id"] . '</td>';
					echo '<td>' . $username . '</td>';
					echo '<td class="col3" title="' . $line["message"] . '">' . $line["message"] . '</td>';
					echo '<td class="col4">' . $line["date"] . '</td>';
					echo "</tr>";
				}
				$i++;
			}
			?>
		</tbody>
	</table>
	<form class="pageGroup" method="GET">
		<input type="hidden" name="trace">
		<?php
			if ($_GET["page"] != 1) {
		?>
		<button class="button" type="submit" name="page" value="<?= $_GET["page"] -1 ?>"><i class="ri-arrow-left-s-line"></i></button>
		<?php
			} else {
		?>
		<button class="button" disabled><i class="ri-arrow-left-s-line"></i></button>
		<?php
			}
			if (count(LogRepository::getLogs()) >= $_GET["page"] * $max) {
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
<?php
// If errors are ask
} else if (isset($_GET["error"])) {
	// Select current date if no one is given: default value
	if (!isset($_GET["date"])) {
		$fileDate = date("Y-m-d");
	} else {
		$fileDate = $_GET["date"];
	}
?>

<div class="mainbox buttonContainer">
	<a href="/logs?trace">
		<button class="button"><i class="ri-draft-line"></i> <?= lang("LOG_TRACE") ?></button>
	</a>
	<a href="/logs?error">
		<button class="button"><i class="ri-error-warning-line"></i> <?= lang("LOG_ERROR") ?></button>
	</a>
	<form method="get">
		<input type="hidden" name="error">
		<input type="date" id="date" name="date" value="<?= $fileDate ?>">
		<button class="button" type="submit"><?= lang("LOG_ERROR_SUBMIT") ?></button>
	</form>
</div>

<?php
	// Get errors file
	$file = $_SERVER["DOCUMENT_ROOT"] . "/log/" . $fileDate . ".log";
	if (file_exists($file)) {
		$logs = file_get_contents($file);
?>

<div class="mainbox maintable">
	<table>
		<thead>
			<tr>
				<th><?= lang("LOG_ERROR_ERROR") ?></th>
				<th><?= lang("LOG_ERROR_MESSAGE") ?></th>
				<th><?= lang("LOG_ERROR_DATE") ?></th>
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

			if (!isset($_GET["page"])) {
				$_GET["page"] = 1;
			}

			$max = 20;
			$i = -1;
			foreach($log as $temp) {
				if ($i >= ($_GET["page"] -1) * $max && $i < $_GET["page"] * $max) {
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
						echo "<td class='col3' title='" . htmlspecialchars($error) . "'>" . htmlspecialchars($error) . "</td>";
						echo "<td class='col3' title='" . str_replace("##", "#", htmlspecialchars($message)) . "'>" . htmlspecialchars(str_replace("##", "#", $message)) . "</td>";
						echo "<td class='col3'>" . $listDate[$i] . "</td>";
						echo "</tr>";
					}
				}
				$i++;
			}
		?>
		</tbody>
	</table>
	<form class="pageGroup" method="GET">
		<input type="hidden" name="error">
		<input type="hidden" name="date" value="<?= $fileDate ?>">
		<?php
			if ($_GET["page"] != 1) {
		?>
		<button class="button" type="submit" name="page" value="<?= $_GET["page"] -1 ?>"><i class="ri-arrow-left-s-line"></i></button>
		<?php
			} else {
		?>
		<button class="button" disabled><i class="ri-arrow-left-s-line"></i></button>
		<?php
			}
			if (count($log) >= $_GET["page"] * $max) {
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

	<?php
	} else {
		echo "<div class='nologmain'><div class='nologcontent'><a class='nologtitle'>" . lang("LOG_ERROR_FILENOTFOUND") . "</a></div></div>";
	}
	?>

<?php
}
?>

<?php
	require($_SERVER["DOCUMENT_ROOT"] . '/include/footer.php');
?>
