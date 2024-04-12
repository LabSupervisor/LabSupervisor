<?php

namespace LabSupervisor\functions;


if (!function_exists(__NAMESPACE__ . "/uidGen")) {
	function uidGen() {
		$char = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_";
		$result = "";
		$randomByte = random_bytes(10);

		foreach (str_split($randomByte) as $byte) {
			$random = ord($byte) % strlen($char);
			$result .= $char[$random];
		}

		return $result;
	}
}
