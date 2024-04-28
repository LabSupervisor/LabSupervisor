<?php

namespace LabSupervisor\app\repository;
use
	PDO,
	Exception;

class LogRepository extends Exception{
	public static function dbSave($message) {
		try {
			// Insert log query
			$query = "INSERT INTO log (iduser, message) VALUES (:iduser, :message)";

			if (isset($_SESSION["login"])) {
				// Get user ID
				$userId = $_SESSION["login"];

				// Insert log
				$queryPrep = DATABASE->prepare($query);
				$queryPrep->bindParam(':iduser', $userId);
				$queryPrep->bindParam(':message', $message);

				if (!$queryPrep->execute())
					throw new Exception("DB Log save error ");
			}
		} catch (Exception $e) {
			// Log error
			LogRepository::fileSave($e);
		}
	}

	public static function fileSave(Exception $e) {
		$stacktrace = $e->getTraceAsString();
		$message = $e->getMessage();
		$logFile = $_SERVER["DOCUMENT_ROOT"] . "/log/" . date("Y-m-d") . ".log";

		// Check if log folder exist
		if (!file_exists($_SERVER["DOCUMENT_ROOT"] . "/log/"))
			mkdir($_SERVER["DOCUMENT_ROOT"] . "/log", 0777, true);

		// Open or create log file if not exist
		$file = fopen($logFile, "a+");

		// Log in file
		fwrite($file, "[" . date("Y-m-d H:i:s") . "]\n");
		foreach(explode("#", $stacktrace) as $value)
			fwrite($file, "#" . $value);
		fwrite($file, "\n" . $message . "\n");
		fclose($file);
	}

	public static function getLogs() {
		// Get logs query
		$query = "SELECT * FROM log ORDER BY id DESC";

		// Get logs
		try {
			$queryPrep = DATABASE->prepare($query);
			if (!$queryPrep->execute())
				throw new Exception("Get logs error");
		} catch (Exception $e) {
			// Log error
			LogRepository::fileSave($e);
		}

		return $queryPrep->fetchAll(PDO::FETCH_ASSOC) ?? NULL;
	}
}
