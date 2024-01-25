<?php
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_header.php");
	mainHeader("Sessions");
?>

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

	<table>
		<thead>
			<td>Sujet</td>
			<td>Précisions</td>
			<td>Professeur</td>
			<td>Date de début</td>
			<td>Date de fin</td>
		</thead>
		<tbody>
			<?php
				for($i = 0; $i < count($sessionList); $i++) {
					echo "<tr>";
					foreach($sessionList[$i] as $line) {
						echo "<td>". $line["title"] ."</td>";
						echo "<td>". $line["description"] ."</td>";
						echo "<td>". getName($line["idcreator"]) ."</td>";
						echo "<td>". $line["startdate"] ."</td>";
						echo "<td>". $line["enddate"] ."</td>";
					}
					echo "</tr>";
				}
			?>
		</tbody>
	</table>
