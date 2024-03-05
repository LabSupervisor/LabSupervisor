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
		$passwordHash = UserRepository::getInfo($email)["password"];

		return password_verify($password, $passwordHash) ?? NULL;
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
		$query = "SELECT us.*, rl.student, rl.teacher, rl.admin FROM user us, role rl WHERE us.email = :email and us.id = rl.iduser";

		// Get user ID
		try {
			$queryPrep = $db->prepare($query);
			$queryPrep->bindParam(':email', $email);
			if (!$queryPrep->execute())
				throw new Exception("Get user datas " . $email . " error");
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

	public static function getUsers() {
		$db = dbConnect();

		// Get users query
		$query = "SELECT us.id, us.surname, us.name, us.email, us.birthdate, rl.student, rl.teacher, rl.admin, cl.name AS 'classroom', us.active FROM user us INNER JOIN role rl ON us.id = rl.iduser LEFT JOIN userclassroom ucl ON us.id = ucl.iduser LEFT JOIN classroom cl ON cl.id = ucl.idclassroom ORDER BY id";

		// Get users
		try {
			$queryPrep = $db->prepare($query);
			if (!$queryPrep->execute())
				throw new Exception("Get users error");
		} catch (Exception $e) {
			LogRepository::fileSave($e);
		}

		return $queryPrep->fetchAll(PDO::FETCH_ASSOC) ?? NULL;
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

	public static function link($userId, $moduleId) {
		$db = dbConnect();

		$query = "";
		// Link query
		if (UserRepository::getLink(UserRepository::getEmail($userId))) {
			$query = "UPDATE link SET idlink = :idlink WHERE iduser = :iduser";
		} else {
			$query = "INSERT INTO link (iduser, idlink) VALUES (:iduser, :idlink)";
		}

		// Link
		try {
			$queryPrep = $db->prepare($query);
			$queryPrep->bindParam(':iduser', $userId);
			$queryPrep->bindParam(':idlink', $moduleId);

			if ($queryPrep->execute())
				LogRepository::dbSave("Link " . $moduleId . " create to " . $userId);
			else
				throw new Exception("Link " . $moduleId . " to " . $userId . " error");
		} catch (Exception $e) {
			LogRepository::fileSave($e);
		}
	}

	public static function getLink($email) {
		$db = dbConnect();

		$userId = UserRepository::getId($email);

		// Get link query
		$query = "SELECT idlink FROM link WHERE iduser = :iduser";

		// Get link
		try {
			$queryPrep = $db->prepare($query);
			$queryPrep->bindParam(':iduser', $userId);
			if (!$queryPrep->execute())
				throw new Exception("Get link " . $email . " error");
		} catch (Exception $e) {
			LogRepository::fileSave($e);
		}

		return $queryPrep->fetchAll(PDO::FETCH_COLUMN)[0] ?? NULL;
	}

	public static function getUserByLink($linkId) {
		$db = dbConnect();

		// Get link query
		$query = "SELECT iduser FROM link WHERE idlink = :idlink";

		// Get link
		try {
			$queryPrep = $db->prepare($query);
			$queryPrep->bindParam(':idlink', $linkId);
			if (!$queryPrep->execute())
				throw new Exception("Get user with link " . $linkId . " error");
		} catch (Exception $e) {
			LogRepository::fileSave($e);
		}

		return $queryPrep->fetchAll(PDO::FETCH_COLUMN)[0] ?? NULL;
	}
}
