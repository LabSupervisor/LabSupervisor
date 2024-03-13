<?php
	require($_SERVER["DOCUMENT_ROOT"] . '/logic/ft_header.php');
	mainHeader("Role Test");

	permissionChecker(true, true, false, true);
	echo "Access!";
?>
