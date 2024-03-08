<?php

function nameFormat($email, $nameIsFirst) {
	$user = UserRepository::getInfo($email);

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
