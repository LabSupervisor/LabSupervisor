<?php
	require($_SERVER["DOCUMENT_ROOT"] . '/logic/ft_header.php');
	mainHeader("DB Test");

	$db = dbConnect();

	$query = "SELECT * FROM user";

	$reqPrep = $db->prepare($query);
	$reqPrep->execute();

	foreach($reqPrep->fetchAll() as $value => $key) {
		echo $value . "<br>";
	}
?>
