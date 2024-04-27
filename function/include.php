<?php

// Include all functions

$functionPath = dirname(__FILE__) . "/../function/";

$files = array_diff(scandir($functionPath), array(".", "..", "include.php"));

foreach ($files as $file) {
	require_once $functionPath . $file;
}
