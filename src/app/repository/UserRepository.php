<?php

class UserRepository {

	public function __construct() {}

	public function createUser(User $entity) {
        if ($entity != NULL) {
            $bindParam = $entity->__toArray();
			// check if user doesn't exist
			if (!$this->getId($bindParam["email"])) {
				$db = dbConnect();

				// Create user query
				$query = "INSERT INTO user (email, password, name, surname, birthdate) VALUES (:email, :password, :name, :surname, :birthdate)";

				// Hash password using bcrypt
				$password = password_hash($bindParam["password"], PASSWORD_BCRYPT);

				// Create user
				try {
					$queryPrep = $db->prepare($query);
					$queryPrep->bindParam(":email", $bindParam["email"]);
					$queryPrep->bindParam(":password", $password);
					$queryPrep->bindParam(":name", $bindParam["name"]);
					$queryPrep->bindParam(":surname", $bindParam["surname"]);
					$queryPrep->bindParam(":birthdate", $bindParam["birthDate"]);
					if (!$queryPrep->execute())
						throw new Exception("Create user " . $bindParam["email"] . " error");
				} catch (Exception $e) {
					LogRepository::fileSave($e);
				}

				$userId = $this->getId($bindParam["email"]);

				// Create user role query
				$queryRole = "INSERT INTO role (iduser) VALUES (:iduser)";

				// Create user role
				try {
					$queryPrepRole = $db->prepare($queryRole);
					$queryPrepRole->bindParam(":iduser", $userId);
					if (!$queryPrepRole->execute())
						throw new Exception("Create user role " . $bindParam["email"] . " error");
				} catch (Exception $e) {
					LogRepository::fileSave($e);
				}

				// Create user setting query
				$querySetting = "INSERT INTO setting (iduser) VALUES (:iduser)";

				// Create user setting
				try {
					$queryPrepSetting = $db->prepare($querySetting);
					$queryPrepSetting->bindParam(":iduser", $userId);
					if (!$queryPrepSetting->execute())
						throw new Exception("Create user setting " . $bindParam["email"] . " error");
				} catch (Exception $e) {
					LogRepository::fileSave($e);
				}
			} else {
				// If user already exist
				$this->update($entity);
			}
		}
	}

	public function update(User $entity) {
		$db = dbConnect();

		$bindParam = $entity->__toArray();

		if ($bindParam["password"])
			$password = password_hash($bindParam["password"], PASSWORD_BCRYPT);
		else
			$password = UserRepository::getInfo($bindParam["email"])["password"];

		// Update user query
		$query = "UPDATE user SET password = :password, name = :name, surname = :surname, birthdate = :birthdate, updatedate = current_timestamp() WHERE email = :email";

		// Update user
		try {
			$queryPrep = $db->prepare($query);
			$queryPrep->bindParam(":email", $bindParam["email"]);
			$queryPrep->bindParam(":password", $password);
			$queryPrep->bindParam(":name", $bindParam["name"]);
			$queryPrep->bindParam(":surname", $bindParam["surname"]);
			$queryPrep->bindParam(":birthdate", $bindParam["birthDate"]);
			if ($queryPrep->execute())
				LogRepository::dbSave("Update user " . $bindParam["email"]);
			else
				throw new Exception("Update user " . $bindParam["email"] . " error");
		} catch (Exception $e) {
			LogRepository::fileSave($e);
		}
	}

	public static function verifyPassword($email, $password) {
		$db = dbConnect();

		// Verify password query
		$query = "SELECT password FROM user WHERE email = :email";

		// Verify password
		try {
			$queryPrep = $db->prepare($query);
			$queryPrep->bindparam(":email", $email);
			if (!$queryPrep->execute())
				throw new Exception("Verify password " . $email . " error");
		} catch (Exception $e) {
			LogRepository::fileSave($e);
		}

		$passwordHash = $queryPrep->fetch(PDO::FETCH_ASSOC);
		return password_verify($password, $passwordHash["password"]) ?? NULL;
	}

	public static function delete($email) {
		$db = dbConnect();

		$userId = UserRepository::getId($email);

		// Delete user query
		$query = "UPDATE user SET email = 'deleted#" . $userId . "', password = 'deleted', name = 'deleted', surname = 'deleted', birthDate = '1970-01-01', updatedate = current_timestamp(), active = 0 WHERE id = :iduser";

		// Delete user
		try {
			$queryPrep = $db->prepare($query);
			$queryPrep->bindParam(":iduser", $userId);
			if ($queryPrep->execute())
				LogRepository::dbSave("User " . $userId . " delete");
			else
				throw new Exception("Delete user " . $userId . " error");
		} catch (Exception $e) {
			LogRepository::fileSave($e);
		}
	}

	public static function getId($email) {
		$db = dbConnect();

		// Get user ID query
		$query = "SELECT id FROM user WHERE email = :email";

		// Get user ID
		try {
			$queryPrep = $db->prepare($query);
			$queryPrep->bindParam(':email', $email);
			if (!$queryPrep->execute())
				throw new Exception("Get user id " . $email . " error");
		} catch (Exception $e) {
			LogRepository::fileSave($e);
		}

		return $queryPrep->fetchAll(PDO::FETCH_COLUMN)[0] ?? NULL;
	}

	public static function getEmail($userId) {
		$db = dbConnect();

		// Get user ID query
		$query = "SELECT email FROM user WHERE id = :iduser";

		// Get user ID
		try {
			$queryPrep = $db->prepare($query);
			$queryPrep->bindParam(':iduser', $userId);
			if (!$queryPrep->execute())
				throw new Exception("Get user " . $userId . " email error");
		} catch (Exception $e) {
			LogRepository::fileSave($e);
		}

		return $queryPrep->fetchAll(PDO::FETCH_COLUMN)[0] ?? NULL;
	}

	public static function getInfo($email) {
		$db = dbConnect();

		// Get user ID query
		$query = "SELECT * FROM user WHERE email = :email";

		// Get user ID
		try {
			$queryPrep = $db->prepare($query);
			$queryPrep->bindParam(':email', $email);
			if (!$queryPrep->execute())
				throw new Exception("Get user password " . $email . " error");
		} catch (Exception $e) {
			LogRepository::fileSave($e);
		}

		return $queryPrep->fetchAll(PDO::FETCH_ASSOC)[0] ?? NULL;
	}

	public static function getSetting($email) {
		$db = dbConnect();

		$userId = UserRepository::getId($email);

		// Get user ID query
		$query = "SELECT * FROM setting WHERE iduser = :iduser";

		// Get user ID
		try {
			$queryPrep = $db->prepare($query);
			$queryPrep->bindParam(':iduser', $userId);
			if (!$queryPrep->execute())
				throw new Exception("Get user setting " . $email . " error");
		} catch (Exception $e) {
			LogRepository::fileSave($e);
		}

		return $queryPrep->fetchAll(PDO::FETCH_ASSOC)[0] ?? NULL;
	}

	public static function isActive($email) {
		$db = dbConnect();

		// Get user ID query
		$query = "SELECT active FROM user WHERE email = :email";

		// Get user ID
		try {
			$queryPrep = $db->prepare($query);
			$queryPrep->bindParam(':email', $email);
			if (!$queryPrep->execute())
				throw new Exception("Get active user " . $email . " error");
		} catch (Exception $e) {
			LogRepository::fileSave($e);
		}

		return $queryPrep->fetchAll(PDO::FETCH_COLUMN)[0] ?? NULL;
	}

	public static function updateSetting($setting) {
		$db = dbConnect();

		$date = date('Y-m-d H:i:s');
		$userId = UserRepository::getId($_SESSION["login"]);

		// Theme query
		$queryTheme = "UPDATE setting SET theme = :theme, updatedate = :date WHERE iduser = :iduser";

		// Theme
		try {
			$queryPrepTheme = $db->prepare($queryTheme);
			$queryPrepTheme->bindParam(':iduser', $userId);
			$queryPrepTheme->bindParam(':theme', $setting["theme"]);
			$queryPrepTheme->bindParam(':date', $date);

			if ($queryPrepTheme->execute())
				LogRepository::dbSave("Theme change to " . $setting["theme"]);
			else
				throw new Exception("Theme " . $setting["theme"] . " change error");
		} catch (Exception $e) {
			LogRepository::fileSave($e);
		}
	}
}
