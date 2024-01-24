<?php
	require($_SERVER['DOCUMENT_ROOT'] . '/logic/ft_header.php');
	mainHeader("Role Test");

	$_SESSION["login"] = "a";

	require($_SERVER['DOCUMENT_ROOT'] . "/logic/ft_permissionChecker.php");
	permissionChecker(true, false, true);
	echo "Access!";
?>
