<?php
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_header.php");
	mainHeader("Log");
?>

<?php
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_getDBLog.php");
?>

<?php
	if (isset($_GET["trace"])) {
?>
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
					echo "<td>". $line["id"] ."</td>";
					echo "<td>". getName($line["iduser"]) ."</td>";
					echo "<td>". $line["message"] ."</td>";
					echo "<td>". $line["date"] ."</td>";
					echo "</tr>";
				}
			?>
		</tbody>
	</table>

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

<a href="<?="http://" . $_SERVER["SERVER_NAME"] . "/log.php?trace"?>">
	<button>Trace</button>
</a>
<a href="<?="http://" . $_SERVER["SERVER_NAME"] . "/log.php?error"?>">
	<button>Erreur</button>
</a>
