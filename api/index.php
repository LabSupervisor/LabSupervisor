<?php

switch($_SERVER["REQUEST_METHOD"]) {
	case "POST":
		try {
			// Get value
			$json = file_get_contents("php://input");
			$data = json_decode($json);

			if ($data->ask == "lslink_get_state") {
				$linkInfo = UserRepository::getLinkInfo($data->id);
				// $status = SessionRepository::getLastUpdateState($linkInfo["iduser"]);
				if ($linkInfo) {
					$status = SessionRepository::getSessionStatus($linkInfo["iduser"], $linkInfo["idsession"]);

					$statusDisplay = 0;
					// If student need help
					if (in_array("1", $status)) {
						$statusDisplay = 1;
					} else {
						// If student is working
						if (in_array("2", $status)) {
							$statusDisplay = 2;
						// If student finish tasks
						} else {
							if (in_array("3", $status)) {
								$statusDisplay = 3;
							// If no tasks started
							} else {
								$statusDisplay = 0;
							}
						}
					}

					echo '{"Response": {"Status": ' . $statusDisplay . '}}';
				} else {
					echo '{"Response": {"Error": "Unlink card"}}';
				}
			}

			if ($data->ask == "get_state") {
				$status = SessionRepository::getStatus($data->idChapter, $data->idUser);
				// Answer API
				echo '{"Response": {"Status": ' . $status . '}}';
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
