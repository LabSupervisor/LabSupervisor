<?php

class ActiveDirectoryRepository {
	protected static $connection;

	public function __construct() {
		try {
			$serverUrl = $_ENV["AD_URL"] . ", " . $_ENV["AD_PORT"];

			$connectionData = array("Database" => $_ENV["AD_NAME"], "UID" => $_ENV["AD_USERNAME"], "PWD" => $_ENV["AD_PASSWORD"]);

			$connection = sqlsrv_connect($serverUrl, $connectionData);

			if(!$connection) {
				throw new Exception(sqlsrv_errors());
			}
		} catch (Exception $e) {
			LogRepository::fileSave($e);
		}
	}

	public function getConnection() {
		return self::$connection;
	}
}
