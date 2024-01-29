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
			<td>ID</td>
			<td>Utilisateur</td>
			<td>Message</td>
			<td>Date</td>
		</thead>
		<tbody>
			<?php
				$logs = getDBLog();

				foreach($logs as $line) {
					echo "<tr>";
					echo '<th class="col1">'. $line["id"] .'</th>';
					echo '<td class="col2">'. getName($line["iduser"]) .'</td>';
					echo '<td class="col3">'. $line["message"] .'</td>';
					echo '<td class="col4">'. $line["date"] .'</td>';
					echo "</tr>";
				}
			?>
		</tbody>
		
	</table>
	<div class="button-container">
		<a href="<?="http://" . $_SERVER["SERVER_NAME"] . "/pages/log.php?trace"?>">
			<button>Trace</button>
		</a>
		<a href="<?="http://" . $_SERVER["SERVER_NAME"] . "/pages/log.php?error"?>">
			<button>Erreur</button>
		</a>
	</div>
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
			<td>Erreur</td>
			<td>Message</td>
			<td>Date</td>
		</thead>
		<tbody>
			<?php
				foreach($logs as $line) {
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
					echo "<td>". $error ."</td>";
					echo "<td>". $message ."</td>";
					echo "<td>". $date ."</td>";
					echo "</tr>";
				}
			?>
			
		</tbody>
	</table>


<?php
			} else {
				echo "Fichier introuvable";
			}
?>
			<form method="get">
				<input type="hidden" name="error"></input>
				<input type="date" name="date"></input>
				<input type="submit">
			</form>
<?php
		}
?>


