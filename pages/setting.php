<?php
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_header.php");
	mainHeader("Options");
?>

<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
?>

<?php
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
				Fond d'écran
			</td>
			<td>
				<select name="background">
					<?php
						foreach ($background as $key => $value) {
							echo "<option>" . $value . "</option>";
						}
					?>
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
