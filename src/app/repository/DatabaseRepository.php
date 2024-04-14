<?php

namespace LabSupervisor\app\repository;
use
	PDO,
	Exception;

class DatabaseRepository {
	private $connection;

	public function __construct() {
		try {
			$hostname = $_ENV['DATABASE_HOST'];
			$port = $_ENV['DATABASE_PORT'];
			
			$dbname = $_ENV['DATABASE_NAME'];
			$username = $_ENV['DATABASE_USER'];
			$password = $_ENV['DATABASE_PASSWORD'];

			$driver = $_ENV['DATABASE_DRIVER'];
			$charset = $_ENV['DATABASE_CHARSET'];

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
