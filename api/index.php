<?php

// Import main functions
require($_SERVER["DOCUMENT_ROOT"] . "/config/config.php");

$method = $_SERVER["REQUEST_METHOD"];

switch($method) {
	case "POST":
		$json = file_get_contents("php://input");
		echo '{"Response": {"Message": "Status updated."}}';

		$data = json_decode($json);

		SessionRepository::setStatus($data->idSession, $data->idChapter, UserRepository::getUserByLink($data->id), $data->idState);

		break;
	default:
		header("Location: /notfound");
}
