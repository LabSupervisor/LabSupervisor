<?php
	require($_SERVER['DOCUMENT_ROOT'] . '/logic/ft_header.php');
	mainHeader("Log Test");

	try {
		throw new Exception("Ah!");
	} catch (Exception $e) {
		$log = new Logs($e);
		$log->fileSave();

		$log->dbSave("1");

		echo "Log!";
	}
?>
