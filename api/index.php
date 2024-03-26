<?php

require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_statusPicker.php");

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
				$status = SessionRepository::getStatus($data->idChapter, $data->idUser);
				// Answer API
				echo '{"Response": {"Status": ' . $status . '}}';
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
				$lang = UserRepository::getSetting(UserRepository::getEmail($data->idUser))["lang"];
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
