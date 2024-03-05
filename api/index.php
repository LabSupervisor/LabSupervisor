<?php

// Import main functions
require($_SERVER["DOCUMENT_ROOT"] . "/config/config.php");

$method = $_SERVER["REQUEST_METHOD"];

switch($method) {
	case "POST":
		$json = file_get_contents("php://input");
		echo $json;

		$data = json_decode($json);

		//TODO update status table if link is done between user and lslink module
		SessionRepository::setStatus($data->idSession, $data->idChapter, UserRepository::getUserByLink($data->id), $data->idState);

		break;
	default:
		header("Location: /notfound");
}
