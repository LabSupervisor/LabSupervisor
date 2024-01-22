<?php
	session_start();
	$_SESSION["login"] = "a";

	require("../config/db.php");
	require("../logic/ft_permissionChecker.php");
	permissionChecker(true, false, false);
?>
