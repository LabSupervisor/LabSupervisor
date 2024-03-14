<?php

function dbConnect()
{
	try {
		// Get database credentials
		$hostname = $_ENV['DATABASE_HOST'];
		$dbname = $_ENV['DATABASE_NAME'];
		$username = $_ENV['DATABASE_USER'];
		$password = $_ENV['DATABASE_PASSWORD'];
		$driver = $_ENV['DATABASE_DRIVER'];
		$port = $_ENV['DATABASE_PORT'];
		$charset = $_ENV['DATABASE_CHARSET'];

		// Create PDO connection
		$db = new PDO("$driver:dbname=$dbname; host=$hostname; port=$port; options='--client_encoding=$charset'", $username, $password);
		$db->exec("SET NAMES '$charset'");

		return $db;

	} catch (Exception $e) {
		// Log error
		LogRepository::fileSave($e);
	}
}
