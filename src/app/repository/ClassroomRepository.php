<?php

namespace LabSupervisor\app\repository;
use
	PDO,
	Exception,
	LabSupervisor\app\entity\Classroom;

class ClassroomRepository {

	public function __construct() {}

	public function createClassroom(Classroom $entity) {
		if ($entity != NULL) {
			$bindParam = $entity->__toArray();
			// check if classroom doesn't exist
			if (!$this->getId($bindParam["name"])) {
				// Create classroom query
				$query = "INSERT INTO classroom (name) VALUES (:name)";

				// Create classroom
				try {
					$queryPrep = DATABASE->prepare($query);
					$queryPrep->bindParam(":name", $bindParam["name"]);
					if (!$queryPrep->execute())
						throw new Exception("Create classroom " . $bindParam["name"] . " error");
				} catch (Exception $e) {
					// Log error
					LogRepository::fileSave($e);
				}
			} else {
				// If classroom already exist
				$this->update($entity);
			}
		}
	}

	public function update(Classroom $entity) {
		$bindParam = $entity->__toArray();

		// Update classroom query
		$query = "UPDATE classroom SET name = :name WHERE id = :id";

		// Update classroom
		try {
			$queryPrep = DATABASE->prepare($query);
			$queryPrep->bindParam(":name", $bindParam["name"]);
			$queryPrep->bindParam(":id", $bindParam["id"]);
			if ($queryPrep->execute())
				LogRepository::dbSave("Update classroom " . $bindParam["name"]);
			else
				throw new Exception("Update classroom " . $bindParam["name"] . " error");
		} catch (Exception $e) {
			// Log error
			LogRepository::fileSave($e);
		}
	}

	public static function getId($name) {
		// Get classroom ID query
		$query = "SELECT id FROM classroom WHERE name = :name";

		// Get classroom ID
		try {
			$queryPrep = DATABASE->prepare($query);
			$queryPrep->bindParam(':name', $name);
			if (!$queryPrep->execute())
				throw new Exception("Get classroom id " . $name . " error");
		} catch (Exception $e) {
			// Log error
			LogRepository::fileSave($e);
		}

		return $queryPrep->fetchAll(PDO::FETCH_COLUMN)[0] ?? NULL;
	}

	public static function getName($id) {
		// Get classroom name query
		$query = "SELECT name FROM classroom WHERE id = :id";

		// Get classroom name
		try {
			$queryPrep = DATABASE->prepare($query);
			$queryPrep->bindParam(':id', $id);
			if (!$queryPrep->execute())
				throw new Exception("Get classroom name " . $id . " error");
		} catch (Exception $e) {
			// Log error
			LogRepository::fileSave($e);
		}

		return $queryPrep->fetchAll(PDO::FETCH_COLUMN)[0] ?? NULL;
	}

	public static function getClassrooms() {
		// Get classrooms query
		$query = "SELECT * FROM classroom";

		// Get classrooms
		try {
			$queryPrep = DATABASE->prepare($query);
			if (!$queryPrep->execute())
				throw new Exception("Get classrooms error");
		} catch (Exception $e) {
			// Log error
			LogRepository::fileSave($e);
		}

		return $queryPrep->fetchAll(PDO::FETCH_ASSOC) ?? NULL;
	}

	public static function getUsers($classroomId) {
		// Get classroom's user query
		$query = "SELECT iduser FROM userclassroom, user WHERE idclassroom = :idclassroom AND user.id = iduser ORDER BY user.surname ASC";

		// Get classroom's user
		try {
			$queryPrep = DATABASE->prepare($query);
			$queryPrep->bindParam(":idclassroom", $classroomId);
			if (!$queryPrep->execute())
				throw new Exception("Get classroom users error");
		} catch (Exception $e) {
			// Log error
			LogRepository::fileSave($e);
		}

		return $queryPrep->fetchAll(PDO::FETCH_ASSOC) ?? NULL;
	}

	public static function getUsersNotInClassroom() {
		// Get user not in classroom query
		$query = "SELECT u.* FROM user u LEFT JOIN userclassroom uc ON u.id = uc.iduser	LEFT JOIN userrole ur ON u.id = ur.iduser WHERE uc.iduser IS NULL AND ur.idrole NOT IN (1, 3) ORDER BY u.surname ASC";

		// Get user not in classroom
		try {
			$queryPrep = DATABASE->prepare($query);
			if (!$queryPrep->execute())
				throw new Exception("Get users not in classroom error");
		} catch (Exception $e) {
			// Log error
			LogRepository::fileSave($e);
		}

		return $queryPrep->fetchAll(PDO::FETCH_ASSOC) ?? NULL;
	}

	public static function getUserClassroom($userId) {
		// Get user classroom query
		$query = "SELECT idclassroom FROM userclassroom WHERE iduser = :iduser";

		// Get user classroom
		try {
			$queryPrep = DATABASE->prepare($query);
			$queryPrep->bindParam(':iduser', $userId);
			if (!$queryPrep->execute())
				throw new Exception("Get user classroom error");
		} catch (Exception $e) {
			// Log error
			LogRepository::fileSave($e);
		}

		return $queryPrep->fetchAll(PDO::FETCH_COLUMN)[0] ?? NULL;
	}

	public static function addUser($userId, $classroomId) {
		// Add user to classroom query
		$query = "INSERT INTO userclassroom (idclassroom, iduser) VALUES (:classroomId, :studentId)";

		// Add user to classroom
		try {
			$queryPrep = DATABASE->prepare($query);
			$queryPrep->bindParam(':classroomId', $classroomId);
			$queryPrep->bindParam(':studentId', $userId);
			if (!$queryPrep->execute())
				throw new Exception("Add user " . $userId. " to " . $classroomId . " error");
		} catch (Exception $e) {
			// Log error
			LogRepository::fileSave($e);
		}
	}

	public static function removeUser($userId, $classroomId) {
		// Remove user from classroom query
		$query = "DELETE FROM userclassroom WHERE idclassroom = :classroomId AND iduser = :studentId";

		// Remove user from classroom
		try {
			$queryPrep = DATABASE->prepare($query);
			$queryPrep->bindParam(':classroomId', $classroomId);
			$queryPrep->bindParam(':studentId', $userId);
			if (!$queryPrep->execute())
				throw new Exception("Remove user " . $userId. " from " . $classroomId . " error");
		} catch (Exception $e) {
			// Log error
			LogRepository::fileSave($e);
		}
	}

	public static function isActive($name) {
		// Get if classroom is active query
		$query = "SELECT active FROM classroom WHERE name = :name";

		// Get if classroom is active
		try {
			$queryPrep = DATABASE->prepare($query);
			$queryPrep->bindParam(':name', $name);
			if (!$queryPrep->execute())
				throw new Exception("Get active classroom " . $name . " error");
		} catch (Exception $e) {
			// Log error
			LogRepository::fileSave($e);
		}

		return $queryPrep->fetchAll(PDO::FETCH_COLUMN)[0] ?? NULL;
	}

	public static function isUserInClassroom($userId, $classroomId) {
		// Get users in classroom query
		$query = "SELECT id FROM userclassroom WHERE idclassroom = :classroomId AND iduser = :studentId";

		// Get users in classroom
		try {
			$queryPrep = DATABASE->prepare($query);
			$queryPrep->bindParam(':classroomId', $classroomId);
			$queryPrep->bindParam(':studentId', $userId);
			if (!$queryPrep->execute())
				throw new Exception("Get is user " . $userId . " in classroom " . $classroomId . " error");
		} catch (Exception $e) {
			// Log error
			LogRepository::fileSave($e);
		}

		return $queryPrep->fetchAll(PDO::FETCH_COLUMN)[0] ?? NULL;
	}

	public static function delete($name) {
		$classroomId = ClassroomRepository::getId($name);

		// Delete classroom query
		$query = "UPDATE classroom SET name = 'deleted#" . $classroomId . "', active = 0 WHERE id = :idclassroom";

		// Delete classroom
		try {
			$queryPrep = DATABASE->prepare($query);
			$queryPrep->bindParam(":idclassroom", $classroomId);
			if ($queryPrep->execute())
				LogRepository::dbSave("Classroom " . $classroomId . " delete");
			else
				throw new Exception("Delete classroom " . $classroomId . " error");
		} catch (Exception $e) {
			// Log error
			LogRepository::fileSave($e);
		}
	}
}
