<?php
	class Logs extends Exception{
		public static function dbSave($message) {
			$db = dbConnect();

			// Get user ID query
			$queryUserId = "SELECT id FROM user WHERE email = :email";
			// Insert log query
			$query = "INSERT INTO log (iduser, message) VALUES (:iduser, :message)";

			// Get user ID
			$queryPrepUserId = $db->prepare($queryUserId);
			$queryPrepUserId->bindParam(':email', $_SESSION["login"], \PDO::PARAM_STR);
			$queryPrepUserId->execute();
			$userId = $queryPrepUserId->fetchAll(PDO::FETCH_COLUMN)[0];

			// Insert log
			$queryPrep = $db->prepare($query);
			$queryPrep->bindParam(':iduser', $userId, \PDO::PARAM_STR);
			$queryPrep->bindParam(':message', $message, \PDO::PARAM_STR);
			$queryPrep->execute();
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
			fwrite($file, "[" . date("Y-m-d H:i:s") . "] " . $stacktrace . ": " . $message . "\n");
			fclose($file);
		}
	}
?>
