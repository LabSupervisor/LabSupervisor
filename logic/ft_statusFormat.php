<?php

function statusFormat($statusId) {
	if ($statusId == 0)
		$status = "";
	if ($statusId == 1)
		$status = "statusRed";
	if ($statusId == 2)
		$status = "statusYellow";
	if ($statusId == 3)
		$status = "statusGreen";

	return "<div class='statusBall $status'></div>";
}
