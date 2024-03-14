<?php

// Import main functions
require($_SERVER["DOCUMENT_ROOT"] . "/config/config.php");

switch($_SERVER["REQUEST_METHOD"]) {
	case "POST":
		try {
			// Get value
			$json = file_get_contents("php://input");
			$data = json_decode($json);

			if ($data->ask == "state") {
				// Update status table
				$status = SessionRepository::getStatus($data->idChapter, UserRepository::getUserByLink($data->id));

				// Answer API
				echo '{"Response": {"Status": ' . $status . '}}';
			}

			if ($data->ask == "update") {
				// Update status table
				if (!SessionRepository::setStatus($data->idSession, $data->idChapter, UserRepository::getUserByLink($data->id), $data->idState)) {
					throw new Exception("API Error");
				}

				// Answer API
				echo '{"Response": {"Message": "Status updated."}}';
			}
		} catch (Exception $e) {
			LogRepository::fileSave($e);
		}

		break;
	default:
		// Redirect unauthorised users
		header("Location: /notfound");
}
