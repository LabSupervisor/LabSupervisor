<?php

require '../config/db.php';
$db = dbConnect();

$query = "SELECT * FROM user";

$reqPrep = $db->prepare($query);
$reqPrep->execute();

var_dump($reqPrep->fetchAll());