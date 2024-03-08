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
				$query = "INSERT INTO user (email, password, name, surname) VALUES (:email, :password, :name, :surname)";

				// Hash password using bcrypt
				$password = password_hash($bindParam["password"], PASSWORD_BCRYPT);

				// Create user
				try {
					$queryPrep = $db->prepare($query);
					$queryPrep->bindParam(":email", $bindParam["email"]);
					$queryPrep->bindParam(":password", $password);
					$queryPrep->bindParam(":name", $bindParam["name"]);
					$queryPrep->bindParam(":surname", $bindParam["surname"]);
					if (!$queryPrep->execute())
						throw new Exception("Create user " . $bindParam["email"] . " error");
				} catch (Exception $e) {
					// Log error
					LogRepository::fileSave($e);
				}

				$userId = $this->getId($bindParam["email"]);

				// Create user role query
				$queryRole = "INSERT INTO userrole (iduser) VALUES (:iduser)";

				// Create user role
				try {
					$queryPrepRole = $db->prepare($queryRole);
					$queryPrepRole->bindParam(":iduser", $userId);
					if (!$queryPrepRole->execute())
						throw new Exception("Create user role " . $bindParam["email"] . " error");
				} catch (Exception $e) {
					// Log error
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
					// Log error
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
		$query = "UPDATE user SET password = :password, name = :name, surname = :surname WHERE email = :email";

		// Update user
		try {
			$queryPrep = $db->prepare($query);
			$queryPrep->bindParam(":email", $bindParam["email"]);
			$queryPrep->bindParam(":password", $password);
			$queryPrep->bindParam(":name", $bindParam["name"]);
			$queryPrep->bindParam(":surname", $bindParam["surname"]);
			if ($queryPrep->execute())
				LogRepository::dbSave("Update user " . $bindParam["email"]);
			else
				throw new Exception("Update user " . $bindParam["email"] . " error");
		} catch (Exception $e) {
			// Log error
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
		$query = "UPDATE user SET email = 'deleted#" . $userId . "', password = 'deleted', name = 'deleted', surname = 'deleted', active = 0 WHERE id = :iduser";

		// Delete user
		try {
			$queryPrep = $db->prepare($query);
			$queryPrep->bindParam(":iduser", $userId);
			if ($queryPrep->execute())
				LogRepository::dbSave("User " . $userId . " delete");
			else
				throw new Exception("Delete user " . $userId . " error");
		} catch (Exception $e) {
			// Log error
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
			// Log error
			LogRepository::fileSave($e);
		}

		return $queryPrep->fetchAll(PDO::FETCH_COLUMN)[0] ?? NULL;
	}

	public static function getEmail($userId) {
		$db = dbConnect();

		// Get user's email query
		$query = "SELECT email FROM user WHERE id = :iduser";

		// Get user's email
		try {
			$queryPrep = $db->prepare($query);
			$queryPrep->bindParam(':iduser', $userId);
			if (!$queryPrep->execute())
				throw new Exception("Get user " . $userId . " email error");
		} catch (Exception $e) {
			// Log error
			LogRepository::fileSave($e);
		}

		return $queryPrep->fetchAll(PDO::FETCH_COLUMN)[0] ?? NULL;
	}

	public static function getInfo($email) {
		$db = dbConnect();

		// Get user's datas query
		$query = "SELECT * FROM user WHERE email = :email";

		// Get user's datas
		try {
			$queryPrep = $db->prepare($query);
			$queryPrep->bindParam(':email', $email);
			if (!$queryPrep->execute())
				throw new Exception("Get user datas " . $email . " error");
		} catch (Exception $e) {
			// Log error
			LogRepository::fileSave($e);
		}

		return $queryPrep->fetchAll(PDO::FETCH_ASSOC)[0] ?? NULL;
	}

	public static function getRole($email) {
		$db = dbConnect();

		$userId = UserRepository::getId($email);

		// Get user's roles query
		$query = "SELECT idrole FROM userrole WHERE iduser = :iduser";

		// Get user's roles
		try {
			$queryPrep = $db->prepare($query);
			$queryPrep->bindParam(':iduser', $userId);
			if (!$queryPrep->execute())
				throw new Exception("Get user " . $email . " roles error");
		} catch (Exception $e) {
			// Log error
			LogRepository::fileSave($e);
		}

		return $queryPrep->fetchAll(PDO::FETCH_ASSOC) ?? NULL;
	}

	public static function getSetting($email) {
		$db = dbConnect();

		$userId = UserRepository::getId($email);

		// Get user's settings query
		$query = "SELECT * FROM setting WHERE iduser = :iduser";

		// Get user's settings
		try {
			$queryPrep = $db->prepare($query);
			$queryPrep->bindParam(':iduser', $userId);
			if (!$queryPrep->execute())
				throw new Exception("Get user setting " . $email . " error");
		} catch (Exception $e) {
			// Log error
			LogRepository::fileSave($e);
		}

		return $queryPrep->fetchAll(PDO::FETCH_ASSOC)[0] ?? NULL;
	}

	public static function getUsers() {
		$db = dbConnect();

		// Get users query
		$query = "SELECT us.id, us.surname, us.name, us.email, cl.name AS 'classroom', us.active FROM user us	LEFT JOIN userclassroom ucl ON us.id = ucl.iduser
		LEFT JOIN classroom cl ON cl.id = ucl.idclassroom WHERE us.active = 1 ORDER BY us.id";

		// Get users
		try {
			$queryPrep = $db->prepare($query);
			if (!$queryPrep->execute())
				throw new Exception("Get users error");
		} catch (Exception $e) {
			// Log error
			LogRepository::fileSave($e);
		}

		return $queryPrep->fetchAll(PDO::FETCH_ASSOC) ?? NULL;
	}

	public static function isActive($email) {
		$db = dbConnect();

		// Get if user is active query
		$query = "SELECT active FROM user WHERE email = :email";

		// Get if user is active
		try {
			$queryPrep = $db->prepare($query);
			$queryPrep->bindParam(':email', $email);
			if (!$queryPrep->execute())
				throw new Exception("Get active user " . $email . " error");
		} catch (Exception $e) {
			// Log error
			LogRepository::fileSave($e);
		}

		return $queryPrep->fetchAll(PDO::FETCH_COLUMN)[0] ?? NULL;
	}

	public static function updateSetting($setting) {
		$db = dbConnect();

		$userId = UserRepository::getId($_SESSION["login"]);

		// Update user's settings query
		$queryTheme = "UPDATE setting SET theme = :theme, lang = :lang WHERE iduser = :iduser";

		// Update user's settings
		try {
			$queryPrepTheme = $db->prepare($queryTheme);
			$queryPrepTheme->bindParam(':iduser', $userId);
			$queryPrepTheme->bindParam(':theme', $setting["theme"]);
			$queryPrepTheme->bindParam(':lang', $setting["lang"]);

			if ($queryPrepTheme->execute())
				LogRepository::dbSave("Theme change to " . $setting["theme"]);
			else
				throw new Exception("Theme " . $setting["theme"] . " change error");
		} catch (Exception $e) {
			// Log error
			LogRepository::fileSave($e);
		}
	}

	public static function link($userId, $moduleId) {
		$db = dbConnect();

		$query = "";
		// Create links query
		if (UserRepository::getLink(UserRepository::getEmail($userId))) {
			$query = "UPDATE link SET idlink = :idlink WHERE iduser = :iduser";
		} else {
			$query = "INSERT INTO link (iduser, idlink) VALUES (:iduser, :idlink)";
		}

		// Create link
		try {
			$queryPrep = $db->prepare($query);
			$queryPrep->bindParam(':iduser', $userId);
			$queryPrep->bindParam(':idlink', $moduleId);

			if ($queryPrep->execute())
				LogRepository::dbSave("Link " . $moduleId . " create to " . $userId);
			else
				throw new Exception("Link " . $moduleId . " to " . $userId . " error");
		} catch (Exception $e) {
			// Log error
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
			// Log error
			LogRepository::fileSave($e);
		}

		return $queryPrep->fetchAll(PDO::FETCH_COLUMN)[0] ?? NULL;
	}

	public static function getUserByLink($linkId) {
		$db = dbConnect();

		// Get user by link query
		$query = "SELECT iduser FROM link WHERE idlink = :idlink";

		// Get user by link
		try {
			$queryPrep = $db->prepare($query);
			$queryPrep->bindParam(':idlink', $linkId);
			if (!$queryPrep->execute())
				throw new Exception("Get user with link " . $linkId . " error");
		} catch (Exception $e) {
			// Log error
			LogRepository::fileSave($e);
		}

		return $queryPrep->fetchAll(PDO::FETCH_COLUMN)[0] ?? NULL;
	}
}
