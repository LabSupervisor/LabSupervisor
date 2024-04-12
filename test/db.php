<?php

use function LabSupervisor\functions\mainHeader;

mainHeader("DB Test");

$query = "SELECT * FROM user";

$reqPrep = DATABASE->prepare($query);
$reqPrep->execute();

foreach($reqPrep->fetchAll() as $value => $key) {
	echo $value . "<br>";
}
