<?php

// Include all functions

$files = array_diff(scandir($_SERVER["DOCUMENT_ROOT"] . "/function/"), array(".", "..", "include.php"));

foreach ($files as $file) {
	require_once $_SERVER["DOCUMENT_ROOT"] . "/function/" . $file;
}
