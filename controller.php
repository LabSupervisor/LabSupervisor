<?php

// Import application
require($_SERVER["DOCUMENT_ROOT"] . "/config/config.php");

// Only get main url part
$page = explode("?", $_SERVER["REQUEST_URI"]);

$item = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/config/route.json"));

foreach ($item as $value) {
	if (in_array($page[0], $value->route)) {
		if (isset($value->connect)) {
			if (isset($_SESSION["login"]) == $value->connect) {
				include $value->page;
				return;
			}
		} else {
			include $value->page;
			return;
		}
	}
}

include "page/notfound.php";
