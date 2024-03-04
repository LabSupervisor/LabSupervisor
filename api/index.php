<?php

// Import database
require $_SERVER['DOCUMENT_ROOT'] . "/config/db.php";

$method = $_SERVER["REQUEST_METHOD"];

switch($method) {
	case "POST":
		$json = file_get_contents("php://input");
		// echo $json;
		$db = dbConnect();

		//TODO update status table if link is done between user and lslink module

		break;
	default:
		header("Location: /notfound");
}
