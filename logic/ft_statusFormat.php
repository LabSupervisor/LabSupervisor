<?php

function statusFormat($statusId) {
	$status = "";
	$text = "";
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

	return "<div class='statusBall $status'><a>$text</a></div>";
}
