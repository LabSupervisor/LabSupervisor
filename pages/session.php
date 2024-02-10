<?php
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_header.php");
	mainHeader("Sessions");
?>

<?php
	permissionChecker(true, true, true, true);
?>

<link rel="stylesheet" href="../public/css/session.css">

<?php
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
						echo "<td></td>";
					}
					echo "</tr>";
				}
			?>
		</tbody>
	</table>
</div>
