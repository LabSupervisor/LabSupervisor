<?php
	// Import header
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_header.php");
	mainHeader("Options");

	// Ask for permissions
	permissionChecker(true, array(admin, student, teacher));

	// Logic
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/changeSetting.php");
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_langFormat.php");
?>

<?php
	$userSetting = UserRepository::getSetting($_SESSION["login"]);

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
					<?php
					if ($userSetting["theme"] == "0") {
						echo "<option selected='selected' value='light'>Mode clair</option>";
						echo "<option value='dark'>Mode sombre</option>";
					} else {
						echo "<option value='light'>Mode clair</option>";
						echo "<option selected='selected' value='dark'>Mode sombre</option>";
					}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td>
				Langue
			</td>
			<td>
				<select name="lang">
				<?php
					$langList = scandir($_SERVER['DOCUMENT_ROOT'] . "/lang/");
					$temp = array(".", "..");
					$langList = array_diff($langList, $temp);
					foreach($langList as $lang) {
						$lang = str_replace(".json", "", $lang);
						if ($lang == $userSetting["lang"])
							echo "<option selected='selected' value='" . $lang . "'>" . langFormat($lang) . "</option>";
						else
							echo "<option value='" . $lang . "'>" . langFormat($lang) . "</option>";
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
