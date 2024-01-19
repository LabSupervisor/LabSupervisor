<?php
	class Logs extends Exception{
		protected $logFile;
		protected $logTable;
		protected $stacktrace;
		protected $message;

		function __construct(Exception $e) {
			$this->stacktrace = $e->getTraceAsString();
			$this->message = $e->getMessage();
			$this->logTable = "log";
		}

		public function dbSave($loginId) {
			$db = dbConnect();

			$query = "INSERT INTO " . $this->logTable . " (iduser, message) VALUES (:iduser, :message)";

			$queryPrep = $db->prepare($query);
			$queryPrep->bindParam(':iduser', $loginId, \PDO::PARAM_STR);
			$queryPrep->bindParam(':message', $this->message, \PDO::PARAM_STR);
			$queryPrep->execute();
		}

		public function fileSave() {
			$this->logFile = $_SERVER['DOCUMENT_ROOT'] . "/logs/" . date("Y-m-d") . ".log";

			if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/logs/"))
				mkdir($_SERVER['DOCUMENT_ROOT'] . "/logs", 0777, true);

			$file = fopen($this->logFile, "a+");

			fwrite($file, "\n[" . date("Y-m-d H:i:s") . "] " . $this->stacktrace . ": " . $this->message);
			fclose($file);
		}
	}
?>
