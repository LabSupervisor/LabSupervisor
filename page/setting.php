<?php
	// Import header
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_header.php");
	mainHeader("Options");

	// Ask for permissions
	permissionChecker(true, array(admin, student, teacher));

	// Logic
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/changeSetting.php");
?>

<?php
	$background = array();
	$background = scandir($_SERVER['DOCUMENT_ROOT'] . "/public/img/background/light/");
	$temp = array(".", "..");
	$background = array_diff($background, $temp);
?>

<form method="POST">
	<table>
		<tr>
			<td>
				Thème
			</td>
			<td>
				<select name="theme">
					<option value="light">Mode clair</option>
					<option value="dark">Mode sombre</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>
				Langue
			</td>
			<td>
				<select name="lang">
					<option value="fr_FR">Français</option>
					<option value="en_UK">Anglais</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>
				<input type=submit name="changeSetting" value="Enregistrer"></input>
			</td>
		</tr>
	</table>
</form>
