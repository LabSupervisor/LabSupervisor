<?php

use LabSupervisor\app\repository\UserRepository;

// Import application
require($_SERVER["DOCUMENT_ROOT"] . "/config/config.php");

$item = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/config/route.json"));

foreach ($item as $value) {
	if (in_array(explode("?", $_SERVER["REQUEST_URI"])[0], $value->route)) {
		if (isset($value->connect)) {
			if (isset($_SESSION["login"]) == $value->connect) {
				if (isset($_SESSION["login"])) {
					if (array_intersect($value->role, UserRepository::getRole($_SESSION["login"]))) {
						include $value->page;
						return;
					} else {
						include "page/denied.php";
						return;
					}
				} else {
					include $value->page;
					return;
				}
			}
		} else {
			include $value->page;
			return;
		}
	}
}

include "page/notfound.php";
