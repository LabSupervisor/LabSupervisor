<?php

use
	LabSupervisor\app\repository\UserRepository,
	LabSupervisor\app\repository\SessionRepository,
	LabSupervisor\app\repository\LogRepository;
use function LabSupervisor\functions\statusPicker;

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

				$state = '{"Response": {';

				foreach ($participant as $value) {
					if (UserRepository::isActive($value["iduser"]) == true AND UserRepository::getRole($value["iduser"])[0]["idrole"] == STUDENT) {
						$state .= '"' . $value["iduser"] . '": {';
						foreach ($chapter as $value2) {
							$state .= '"' . $value2["id"] . '" : ' . SessionRepository::getStatus($value2["id"], $value["iduser"]) . ",";
						}
						$state = substr($state, 0, -1);
						$state .= "},";
					}
				}
				$state = substr($state, 0, -1);
				$state .= "}}";

				// Answer API
				echo $state;
			}

			// Application asking to update user status
			if ($data->ask == "update_status") {
				SessionRepository::setStatus($data->idSession, $data->idChapter, $data->idUser, $data->idState);
				// Answer API
				echo '{"Response": {"Message": "Status updated."}}';
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
				if ($data->theme == "light")
					$theme = 0;
				else
					$theme = 1;
				$userSetting = array(
					"theme" => $theme,
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
