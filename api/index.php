<?php

switch($_SERVER["REQUEST_METHOD"]) {
	case "POST":
		try {
			// Get value
			$json = file_get_contents("php://input");
			$data = json_decode($json);

			if ($data->ask == "lslink_state") {
				$status = SessionRepository::getStatus($data->idChapter, UserRepository::getUserByLink($data->id));

				// Answer API
				echo '{"Response": {"Status": ' . $status . '}}';
			}

			if ($data->ask == "state") {
				$status = SessionRepository::getStatus($data->idChapter, $data->idUser);

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
