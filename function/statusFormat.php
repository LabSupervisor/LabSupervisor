<?php

namespace LabSupervisor\functions;

if (!function_exists(__NAMESPACE__ . "/statusFormat")) {
	function statusFormat($userId, $chapterId, $statusId) {
		$status = "";
		$text = lang("DASHBOARD_STATUS_WAITING");
		if ($statusId == 0) {
			$status = "";
		}
		if ($statusId == 1) {
			$status = "statusRed";
			$text = lang("DASHBOARD_STATUS_RED");
		}
		if ($statusId == 2) {
			$status = "statusYellow";
			$text = lang("DASHBOARD_STATUS_YELLOW");
		}
		if ($statusId == 3) {
			$status = "statusGreen";
			$text = lang("DASHBOARD_STATUS_GREEN");
		}

		return "<div id='" . $userId . "_" . $chapterId . "' class='statusBall $status'><a>$text</a></div>";
	}
}
