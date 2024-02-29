<?php
class LogRepository extends Exception{
	public static function dbSave($message) {
		try {
			$db = dbConnect();

			// Insert log query
			$query = "INSERT INTO log (iduser, message) VALUES (:iduser, :message)";

			// Get user ID
			$userId = UserRepository::getId($_SESSION["login"]);

			// Insert log
			$queryPrep = $db->prepare($query);
			$queryPrep->bindParam(':iduser', $userId, \PDO::PARAM_STR);
			$queryPrep->bindParam(':message', $message, \PDO::PARAM_STR);

			if (!$queryPrep->execute())
				throw new Exception("DB Log save error ");
		} catch (Exception $e) {
			LogRepository::fileSave($e);
		}
	}

	public static function fileSave(Exception $e) {
		$stacktrace = $e->getTraceAsString();
		$message = $e->getMessage();
		$logFile = $_SERVER['DOCUMENT_ROOT'] . "/logs/" . date("Y-m-d") . ".log";

		// Check if log folder exist
		if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/logs/"))
			mkdir($_SERVER['DOCUMENT_ROOT'] . "/logs", 0777, true);

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
		$db = dbConnect();

		// Get users query
		$query = "SELECT * FROM log";

		// Get users
		try {
			$queryPrep = $db->prepare($query);
			if (!$queryPrep->execute())
				throw new Exception("Get logs error");
		} catch (Exception $e) {
			LogRepository::fileSave($e);
		}

		return $queryPrep->fetchAll(PDO::FETCH_ASSOC) ?? NULL;
	}
}
