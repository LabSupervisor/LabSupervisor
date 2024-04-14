<?php

namespace LabSupervisor\app\repository;
use
	PDO,
	Exception;

class ActiveDirectoryRepository {
	private $connection;

	public function __construct() {
		try {
			$hostname = $_ENV['AD_URL'];
			$port = $_ENV['AD_PORT'];

			$dbname = $_ENV['AD_NAME'];
			$username = $_ENV['AD_USERNAME'];
			$password = $_ENV['AD_PASSWORD'];

			$driver = "mysql";
			$charset = "UTF8";

			// Create PDO connection
			$this->connection = new PDO("$driver:dbname=$dbname; host=$hostname; port=$port; options='--client_encoding=$charset'", $username, $password);
			$this->connection->exec("SET NAMES '$charset'");

		} catch (Exception $e) {
			// Log error
			LogRepository::fileSave($e);
		}
	}

	public function getConnection() {
		return $this->connection;
	}
}
