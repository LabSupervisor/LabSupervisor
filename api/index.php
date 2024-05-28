<?php

use
	LabSupervisor\app\repository\UserRepository,
	LabSupervisor\app\repository\SessionRepository,
	LabSupervisor\app\repository\LogRepository;
use function
	LabSupervisor\functions\statusPicker,
	LabSupervisor\functions\nameFormat;

header('Content-Type: application/json');

switch($_SERVER["REQUEST_METHOD"]) {
	case "POST":
		try {
			// Get value
			$json = file_get_contents("php://input");
			$data = json_decode($json);

			// LS-LINK asking for state
			if ($data->ask == "lslink_get_state") {
				$linkInfo = UserRepository::getLinkInfo($data->id);
				// Answer API
				if ($linkInfo) {
					echo '{"Response": {"Status": ' . statusPicker(SessionRepository::getSessionStatus($linkInfo["iduser"], $linkInfo["idsession"])) . '}}';
				} else {
					http_response_code(404);
					echo '{"Response": {"Error": 404}}';
				}
			}

			// Application asking for user status
			if ($data->ask == "get_status") {
				$participant = SessionRepository::getParticipants($data->idSession);
				$chapter = SessionRepository::getChapter($data->idSession);

				$response = array();

				foreach ($participant as $value) {
					if (UserRepository::isActive($value["iduser"]) == true && in_array(STUDENT, UserRepository::getRole($value["iduser"]))) {
						$userId = $value["iduser"];
						$response[$userId] = array();

						foreach ($chapter as $chapterId) {
							$response[$userId][$chapterId["id"]] = SessionRepository::getStatus($chapterId["id"], $userId);
						}
					}
				}

				// Answer API
				echo json_encode(["Response" => $response]);
			}

			// Application asking to update user status
			if ($data->ask == "update_status") {
				SessionRepository::setStatus($data->idSession, $data->idChapter, $data->idUser, $data->idState);
				// Answer API
				echo '{"Response": {"Message": "Status updated."}}';
			}

			// Application asking for user done state percent
			if ($data->ask == "get_status_percent") {
				$response = round(SessionRepository::getStatusDone($data->idSession, $data->idUser) / count(SessionRepository::getChapter($data->idSession)) * 100, 2);
				// Answer API
				echo '{"Response": {"Percent": "' . $response . '"}}';
			}

			// Application asking for user done state percent
			if ($data->ask == "get_all_status_percent") {
				// Get participant count
				$userCount = 0;
				foreach (SessionRepository::getParticipants($data->idSession) as $value) {
					if (UserRepository::isActive($value["iduser"]) == true AND in_array(STUDENT, UserRepository::getRole($value["iduser"]))) {
						$userCount++;
					}
				}

				$response = 0;
				if ($userCount > 0) {
					// Percent system
					$response = round(SessionRepository::getAllStatusDone($data->idSession) / (count(SessionRepository::getChapter($data->idSession)) * $userCount) * 100, 2);
				}

				// Answer API
				echo '{"Response": {"Percent": "' . $response . '"}}';
			}

			// Application asking for user name
			if ($data->ask == "get_user_names") {
				$response = nameFormat($data->idUser, true);
				// Answer API
				echo '{"Response": {"Names": "' . $response . '"}}';
			}

			// Application asking for session state
			if ($data->ask == "get_state") {
				$status = SessionRepository::getState($data->idSession);
				// Answer API
				if (isset($status)) {
					echo '{"Response": {"Status": ' . $status . '}}';
				} else {
					http_response_code(404);
					echo '{"Response": {"Error": 404}}';
				}
			}

			// Application asking to update user theme
			if ($data->ask == "update_theme") {
				// Update theme
				$lang = UserRepository::getSetting($data->idUser)["lang"];
				$userSetting = array(
					"theme" => $data->theme,
					"lang" => $lang
				);
				// Update user's settings
				UserRepository::updateSetting($data->idUser, $userSetting);
				// Answer API
				echo '{"Response": {"Message": "Theme updated."}}';
			}
		} catch (Exception $e) {
			LogRepository::fileSave($e);
		}

		break;
	default:
		// Redirect unauthorised users
		header("Location: /notfound");
}
