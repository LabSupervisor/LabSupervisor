<?php

namespace LabSupervisor\functions;
use LabSupervisor\app\repository\UserRepository;

if (!function_exists(__NAMESPACE__ . "/nameFormat")) {
	function nameFormat($userId, $nameIsFirst) {
		$user = UserRepository::getInfo($userId);

		// "John S."
		if ($nameIsFirst) {
			$surname = substr($user["surname"], 0, 1);
			return $user["name"] . " " . $surname . ".";
		// "J. Snow"
		} else {
			$name = substr($user["name"], 0, 1);
			return $name . ". " . $user["surname"];
		}
	}
}
