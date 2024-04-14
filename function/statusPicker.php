<?php

namespace LabSupervisor\functions;

if (!function_exists(__NAMESPACE__ . "/statusPicker")) {
	function statusPicker($statusList) {
		// If student need help
		if (in_array("1", $statusList)) {
			return 1;
		} else {
			// If student is working
			if (in_array("2", $statusList)) {
				return 2;
			// If student finish tasks
			} else {
				if (in_array("3", $statusList)) {
					return 3;
				// If no tasks started
				} else {
					return 0;
				}
			}
		}
	}
}
