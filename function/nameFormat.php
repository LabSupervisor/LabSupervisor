<?php

namespace LabSupervisor\functions;
use LabSupervisor\app\repository\UserRepository;

if (!function_exists(__NAMESPACE__ . "/nameFormat")) {
	function nameFormat($userId, $nameIsFirst) {
		$user = UserRepository::getInfo($userId);

		// "John S."
		if ($nameIsFirst) {
			$surname = substr(ucfirst(strtolower($user["surname"])), 0, 1);
			return htmlspecialchars(ucfirst(strtolower($user["name"])) . " " . $surname . ".");
		// "J. Snow"
		} else {
			$name = substr(ucfirst(strtolower($user["name"])), 0, 1);
			return htmlspecialchars($name . ". " . ucfirst(strtolower($user["surname"])));
		}
	}
}
