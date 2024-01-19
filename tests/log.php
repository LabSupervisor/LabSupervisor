<?php
	require($_SERVER['DOCUMENT_ROOT'] . "/config/db.php");
	require($_SERVER['DOCUMENT_ROOT'] . "/src/App/Repositories/log.php");

	try {
		throw new Exception("Ah!");
	} catch (Exception $e) {
		$log = new Logs($e);
		$log->fileSave();

		$log->dbSave("1");
	}
?>
