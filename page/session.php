<?php
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_header.php");
	mainHeader("Sessions");

	$roleList = permissionChecker(true, true, true, true);

	// Logic
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/joinSession.php");
?>

<link rel="stylesheet" href="../public/css/session.css">

<?php
	$sessionList = array();
	// Get all sessions for admin
	if (in_array("admin", $roleList)) {
		$session = SessionRepository::getSessions();

		foreach($session as $value => $key) {
			array_push($sessionList, SessionRepository::getInfo($key["id"]));
		}
	// Get user's session
	} else {
		$session = SessionRepository::getUserSessions($_SESSION["login"]);

		foreach($session as $value => $key) {
			array_push($sessionList, SessionRepository::getInfo($key["idsession"]));
		}
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
						$creatorName = nameFormat(UserRepository::getEmail($line["idcreator"]), false);

						echo '<td class="col1">'. $line["title"] ."</td>";
						echo '<td class="col2-container">';
						echo '<div class="col2-tooltip">' . htmlspecialchars($line["description"]) . '</div>';
						echo '<div class="col2">'. $line["description"] ."</div>";
						echo '</td>';
						echo '<td class="col3">'. $creatorName ."</td>";
						echo '<td class="col4">'. $line["date"] ."</td>";
						if (!in_array("admin", $roleList)) {
							echo "<td>";

							if ($line["active"]) {
								if ($line["date"] > date('Y-m-d H:i:s')) {
									echo "<i class='ri-timer-line'></i> Prochainement";
								} else {
									echo "<form method='POST'><input type='submit' name='connect[" . $line["id"] . "]' value='Rejoindre' class='button'></input></form>";
								}
							} else {
								echo "Terminé";
							}

							echo "</td>";
						} else {
							echo "<td><i class='ri-lock-line'></i> Verrouillé</td>";
						}
					}
					echo "</tr>";
				}
			?>
		</tbody>
	</table>
</div>
