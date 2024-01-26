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
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/changeBackground.php");
?>

<?php
	$background = array();
	$background = scandir($_SERVER['DOCUMENT_ROOT'] . "/public/img/background/");
	$temp = array(".", "..");
	$background = array_diff($background, $temp);
?>

<form method="POST">
	<select name="background">
		<?php
			foreach ($background as $key => $value) {
				echo "<option>" . $value . "</option>";
			}
		?>
	</select>
	<input type=submit name="changeBackground" value="Modifier"></input>
</form>
