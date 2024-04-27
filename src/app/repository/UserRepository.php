<?php

namespace LabSupervisor\app\repository;
use
	PDO,
	Exception,
	LabSupervisor\app\entity\User;

class UserRepository {

	public function __construct() {}

	public function createUser(User $entity) {
		if ($entity != NULL) {
			$bindParam = $entity->__toArray();
			// check if user doesn't exist
			if (!$this->getId($bindParam["email"])) {
				// Create user query
				$query = "INSERT INTO user (email, password, name, surname) VALUES (:email, :password, :name, :surname)";

				// Hash password using bcrypt
				$password = password_hash($bindParam["password"], PASSWORD_BCRYPT);
				LogRepository::fileSave(new Exception($bindParam["password"]));

				// Create user
				try {
					$queryPrep = DATABASE->prepare($query);
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
					$queryPrepRole = DATABASE->prepare($queryRole);
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
					$queryPrepSetting = DATABASE->prepare($querySetting);
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
		$bindParam = $entity->__toArray();

		if ($bindParam["password"])
			$password = password_hash($bindParam["password"], PASSWORD_BCRYPT);
		else
			$password = UserRepository::getInfo(UserRepository::getId($bindParam["email"]))["password"];

		// Update user query
		$query = "UPDATE user SET password = :password, name = :name, surname = :surname WHERE email = :email";

		// Update user
		try {
			$queryPrep = DATABASE->prepare($query);
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

	public static function verifyPassword($userId, $password) {
		$passwordHash = UserRepository::getInfo($userId)["password"];

		return password_verify($password, $passwordHash) ?? NULL;
	}

	public static function delete($userId) {
		// Delete user query
		$query = "UPDATE user SET email = 'deleted#" . $userId . "', password = 'deleted', name = 'deleted', surname = 'deleted', active = 0 WHERE id = :iduser";

		// Delete user
		try {
			$queryPrep = DATABASE->prepare($query);
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
		// Get user ID query
		$query = "SELECT id FROM user WHERE email = :email";

		// Get user ID
		try {
			$queryPrep = DATABASE->prepare($query);
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
		// Get user's email query
		$query = "SELECT email FROM user WHERE id = :iduser";

		// Get user's email
		try {
			$queryPrep = DATABASE->prepare($query);
			$queryPrep->bindParam(':iduser', $userId);
			if (!$queryPrep->execute())
				throw new Exception("Get user " . $userId . " email error");
		} catch (Exception $e) {
			// Log error
			LogRepository::fileSave($e);
		}

		return $queryPrep->fetchAll(PDO::FETCH_COLUMN)[0] ?? NULL;
	}

	public static function getInfo($userId) {
		// Get user's datas query
		$query = "SELECT * FROM user WHERE id = :iduser";

		// Get user's datas
		try {
			$queryPrep = DATABASE->prepare($query);
			$queryPrep->bindParam(':iduser', $userId);
			if (!$queryPrep->execute())
				throw new Exception("Get user datas " . $userId . " error");
		} catch (Exception $e) {
			// Log error
			LogRepository::fileSave($e);
		}

		return $queryPrep->fetchAll(PDO::FETCH_ASSOC)[0] ?? NULL;
	}

	public static function getRole($userId) {
		// Get user's roles query
		$query = "SELECT idrole FROM userrole WHERE iduser = :iduser";

		// Get user's roles
		try {
			$queryPrep = DATABASE->prepare($query);
			$queryPrep->bindParam(':iduser', $userId);
			if (!$queryPrep->execute())
				throw new Exception("Get user " . $userId . " roles error");
		} catch (Exception $e) {
			// Log error
			LogRepository::fileSave($e);
		}

		return $queryPrep->fetchAll(PDO::FETCH_ASSOC) ?? NULL;
	}

	public static function getRoleId($role) {
		// Get role id query
		$query = "SELECT id FROM role WHERE name = :role";

		// Get role id email
		try {
			$queryPrep = DATABASE->prepare($query);
			$queryPrep->bindParam(':role', $role);
			if (!$queryPrep->execute())
				throw new Exception("Get role " . $role . " id error");
		} catch (Exception $e) {
			// Log error
			LogRepository::fileSave($e);
		}

		return $queryPrep->fetchAll(PDO::FETCH_COLUMN)[0] ?? NULL;
	}

	public static function getSetting($userId) {
		// Get user's settings query
		$query = "SELECT * FROM setting WHERE iduser = :iduser";

		// Get user's settings
		try {
			$queryPrep = DATABASE->prepare($query);
			$queryPrep->bindParam(':iduser', $userId);
			if (!$queryPrep->execute())
				throw new Exception("Get user setting " . $userId . " error");
		} catch (Exception $e) {
			// Log error
			LogRepository::fileSave($e);
		}

		return $queryPrep->fetchAll(PDO::FETCH_ASSOC)[0] ?? NULL;
	}

	public static function getUsers() {
		// Get users query
		$query = "SELECT us.id, us.surname, us.name, us.email, cl.name AS 'classroom', us.active FROM user us	LEFT JOIN userclassroom ucl ON us.id = ucl.iduser
		LEFT JOIN classroom cl ON cl.id = ucl.idclassroom WHERE us.active = 1 GROUP BY email ORDER BY us.id";

		// Get users
		try {
			$queryPrep = DATABASE->prepare($query);
			if (!$queryPrep->execute())
				throw new Exception("Get users error");
		} catch (Exception $e) {
			// Log error
			LogRepository::fileSave($e);
		}

		return $queryPrep->fetchAll(PDO::FETCH_ASSOC) ?? NULL;
	}

	public static function getRoles() {
		// Get roles query
		$query = "SELECT * FROM role";

		// Get roles
		try {
			$queryPrep = DATABASE->prepare($query);
			if (!$queryPrep->execute())
				throw new Exception("Get roles error");
		} catch (Exception $e) {
			// Log error
			LogRepository::fileSave($e);
		}

		return $queryPrep->fetchAll(PDO::FETCH_ASSOC) ?? NULL;
	}

	public static function isActive($userId) {
		// Get if user is active query
		$query = "SELECT active FROM user WHERE id = :iduser";

		// Get if user is active
		try {
			$queryPrep = DATABASE->prepare($query);
			$queryPrep->bindParam(':iduser', $userId);
			if (!$queryPrep->execute())
				throw new Exception("Get active user " . $userId . " error");
		} catch (Exception $e) {
			// Log error
			LogRepository::fileSave($e);
		}

		return $queryPrep->fetchAll(PDO::FETCH_COLUMN)[0] ?? NULL;
	}

	public static function updateSetting($userId, $setting) {
		// Update user's settings query
		$queryTheme = "UPDATE setting SET theme = :theme, lang = :lang WHERE iduser = :iduser";

		// Update user's settings
		try {
			$queryPrepTheme = DATABASE->prepare($queryTheme);
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

	public static function updateRole($userId, $roleId) {
		// Update user's role query
		$queryTheme = "UPDATE userrole SET idrole = :idrole WHERE iduser = :iduser";

		// Update user's role
		try {
			$queryPrepTheme = DATABASE->prepare($queryTheme);
			$queryPrepTheme->bindParam(':iduser', $userId);
			$queryPrepTheme->bindParam(':idrole', $roleId);

			if ($queryPrepTheme->execute())
				LogRepository::dbSave("User " . $userId . " role changed");
			else
				throw new Exception("User " . $userId . " role changed error");
		} catch (Exception $e) {
			// Log error
			LogRepository::fileSave($e);
		}
	}

	public static function link($userId, $sessionId, $moduleId) {
		$query = "";
		// Create links query
		if (UserRepository::getLink($userId, $sessionId)) {
			$query = "UPDATE link SET idlink = :idlink, idSession = :idSession WHERE iduser = :iduser";
		} else {
			$query = "INSERT INTO link (iduser, idSession, idlink) VALUES (:iduser, :idSession, :idlink)";
		}

		// Create link
		try {
			$queryPrep = DATABASE->prepare($query);
			$queryPrep->bindParam(':iduser', $userId);
			$queryPrep->bindParam(':idSession', $sessionId);
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

	public static function unlink($userId, $sessionId, $moduleId) {
		$query = "";
		// Unlinks query
		$query = "DELETE FROM link WHERE iduser = :iduser AND idsession = :idsession AND idlink = :idlink";

		// Unlink
		try {
			$queryPrep = DATABASE->prepare($query);
			$queryPrep->bindParam(':iduser', $userId);
			$queryPrep->bindParam(':idsession', $sessionId);
			$queryPrep->bindParam(':idlink', $moduleId);

			if ($queryPrep->execute())
				LogRepository::dbSave("Unlink " . $moduleId . " from " . $userId);
			else
				throw new Exception("Unlink " . $moduleId . " from " . $userId . " error");
		} catch (Exception $e) {
			// Log error
			LogRepository::fileSave($e);
		}
	}

	public static function getLink($userId, $sessionId) {
		// Get link query
		$query = "SELECT idlink FROM link WHERE iduser = :iduser AND idsession = :idsession";

		// Get link
		try {
			$queryPrep = DATABASE->prepare($query);
			$queryPrep->bindParam(':iduser', $userId);
			$queryPrep->bindParam(':idsession', $sessionId);
			if (!$queryPrep->execute())
				throw new Exception("Get link " . $userId . " error");
		} catch (Exception $e) {
			// Log error
			LogRepository::fileSave($e);
		}

		return $queryPrep->fetchAll(PDO::FETCH_COLUMN)[0] ?? NULL;
	}

	public static function getLinkInfo($linkId) {
		// Get link info query
		$query = "SELECT * FROM link WHERE idlink = :idlink";

		// Get link info
		try {
			$queryPrep = DATABASE->prepare($query);
			$queryPrep->bindParam(':idlink', $linkId);
			if (!$queryPrep->execute())
				throw new Exception("Get user with link " . $linkId . " error");
		} catch (Exception $e) {
			// Log error
			LogRepository::fileSave($e);
		}

		return $queryPrep->fetchAll(PDO::FETCH_ASSOC)[0] ?? NULL;
	}
}
