<?php
	require '../config/db.php';
	$db = dbConnect();

	$query = "SELECT * FROM user";

	$reqPrep = $db->prepare($query);
	$reqPrep->execute();

	foreach($reqPrep->fetchAll() as $value => $key) {
		echo $value . "<br>";
	}
?>
