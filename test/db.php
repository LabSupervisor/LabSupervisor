<?php

require($_SERVER["DOCUMENT_ROOT"] . '/logic/ft_header.php');
mainHeader("DB Test");

$query = "SELECT * FROM user";

$reqPrep = DATABASE->prepare($query);
$reqPrep->execute();

foreach($reqPrep->fetchAll() as $value => $key) {
	echo $value . "<br>";
}
