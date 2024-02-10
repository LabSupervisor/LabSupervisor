<?php
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_header.php");
	mainHeader("Sessions");
?>

<?php
	$role = permissionChecker(true, true, true, true);
?>

<link rel="stylesheet" href="../public/css/session.css">

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_getSession.php");
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_getSessionInfo.php");
?>

<?php
	$session = getSession();
	$sessionList = array();

	foreach($session as $value => $key) {
		array_push($sessionList, getSessionInfo($key["idsession"]));
	}
?>

<div class="table-container">
	<table>
		<thead>
			<tr>
				<td>Sujet</td>
				<td>Précisions</td>
				<td>Professeur</td>
				<td>Date</td>
				<td>Etat</td>
			</tr>
		</thead>
		<tbody>
			<?php
				for($i = 0; $i < count($sessionList); $i++) {
					echo "<tr>";
					foreach($sessionList[$i] as $line) {
						echo '<td class="col1">'. $line["title"] ."</td>";
						echo '<td class="col2-container">';
						echo '<div class="col2-tooltip">' . htmlspecialchars($line["description"]) . '</div>';
						echo '<div class="col2">'. $line["description"] ."</div>";
						echo '</td>';
						echo '<td class="col3">'. getName($line["idcreator"]) ."</td>";
						echo '<td class="col4">'. $line["date"] ."</td>";
						echo "<td>";

						if ($line["active"]) {
							if ($line["date"] > date('Y-m-d H:i:s')) {
								echo "Prochainement";
							} else {
								echo "<form method='POST'><input type='submit' name='session' value='" . $line["id"] . "' class='button'>Rejoindre</input></form>";
							}
						} else {
							echo "Terminé";
						}

						echo "</td>";
					}
					echo "</tr>";
				}
			?>
		</tbody>
	</table>
</div>

<?php
	if (isset($_POST["session"])) {
		if (isset($role["teacher"])) {
			$type = "teacher";
		} else {
			$type = "student";
		}

		$_SESSION["session"] = $_POST["session"];
		// header("Location: /panel");
	}
?>
