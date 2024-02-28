<?php

class ClassroomRepository {

	public function __construct() {}

	public function createClassroom(Classroom $entity) {
        if ($entity != NULL) {
            $bindParam = $entity->__toArray();
			// check if classroom doesn't exist
			if (!$this->getId($bindParam["name"])) {
				$db = dbConnect();

				// Create classroom query
				$query = "INSERT INTO classroom (name) VALUES (:name)";

				// Create classroom
				try {
					$queryPrep = $db->prepare($query);
					$queryPrep->bindParam(":name", $bindParam["name"]);
					if (!$queryPrep->execute())
						throw new Exception("Create classroom " . $bindParam["name"] . " error");
				} catch (Exception $e) {
					LogRepository::fileSave($e);
				}
			} else {
				// If classroom already exist
				$this->update($entity);
			}
		}
	}

	public function update(Classroom $entity) {
		$db = dbConnect();

		$bindParam = $entity->__toArray();
		$classroomId = ClassroomRepository::getId($bindParam["name"]);

		// Update user query
		$query = "UPDATE classroom SET name = :name, updatedate = current_timestamp() WHERE id = :id";

		// Update user
		try {
			$queryPrep = $db->prepare($query);
			$queryPrep->bindParam(":name", $bindParam["name"]);
			$queryPrep->bindParam(":id", $classroomId);
			if ($queryPrep->execute())
				LogRepository::dbSave("Update classroom " . $bindParam["name"]);
			else
				throw new Exception("Update classroom " . $bindParam["name"] . " error");
		} catch (Exception $e) {
			LogRepository::fileSave($e);
		}
	}

	public static function getId($name) {
		$db = dbConnect();

		// Get user ID query
		$query = "SELECT id FROM classroom WHERE name = :name";

		// Get user ID
		try {
			$queryPrep = $db->prepare($query);
			$queryPrep->bindParam(':name', $name);
			if (!$queryPrep->execute())
				throw new Exception("Get classroom id " . $name . " error");
		} catch (Exception $e) {
			LogRepository::fileSave($e);
		}

		return $queryPrep->fetchAll(PDO::FETCH_COLUMN)[0] ?? NULL;
	}

	public static function getName($id) {
		$db = dbConnect();

		// Get user ID query
		$query = "SELECT name FROM classroom WHERE id = :id";

		// Get user ID
		try {
			$queryPrep = $db->prepare($query);
			$queryPrep->bindParam(':id', $id);
			if (!$queryPrep->execute())
				throw new Exception("Get classroom name " . $id . " error");
		} catch (Exception $e) {
			LogRepository::fileSave($e);
		}

		return $queryPrep->fetchAll(PDO::FETCH_COLUMN)[0] ?? NULL;
	}

	public static function getClassrooms() {
		$db = dbConnect();

		// Get classrooms query
		$query = "SELECT * FROM classroom";

		// Get classrooms
		try {
			$queryPrep = $db->prepare($query);
			if (!$queryPrep->execute())
				throw new Exception("Get classrooms error");
		} catch (Exception $e) {
			LogRepository::fileSave($e);
		}

		return $queryPrep->fetchAll(PDO::FETCH_ASSOC) ?? NULL;
	}

	public static function getUsers($name) {
		$db = dbConnect();

		$classroomId = ClassroomRepository::getId($name);

		// Get classrooms query
		$query = "SELECT iduser FROM userclassroom WHERE idclassroom = :idclassroom";

		// Get classrooms
		try {
			$queryPrep = $db->prepare($query);
			$queryPrep->bindParam(":idclassroom", $classroomId);
			if (!$queryPrep->execute())
				throw new Exception("Get classroom users error");
		} catch (Exception $e) {
			LogRepository::fileSave($e);
		}

		return $queryPrep->fetchAll(PDO::FETCH_ASSOC) ?? NULL;
	}

	public static function getUsersNotInClassroom($name) {
		$db = dbConnect();

		$classroomId = ClassroomRepository::getId($name);

		// Get classrooms query
		$query = "SELECT * FROM user WHERE id NOT IN (SELECT iduser FROM userclassroom WHERE idclassroom = :idclassroom) AND user.active = 1";

		// Get classrooms
		try {
			$queryPrep = $db->prepare($query);
			$queryPrep->bindParam(":idclassroom", $classroomId);
			if (!$queryPrep->execute())
				throw new Exception("Get users not in classroom error");
		} catch (Exception $e) {
			LogRepository::fileSave($e);
		}

		return $queryPrep->fetchAll(PDO::FETCH_ASSOC) ?? NULL;
	}

	public static function isActive($name) {
		$db = dbConnect();

		// Get classroom ID query
		$query = "SELECT active FROM classroom WHERE name = :name";

		// Get classroom ID
		try {
			$queryPrep = $db->prepare($query);
			$queryPrep->bindParam(':name', $name);
			if (!$queryPrep->execute())
				throw new Exception("Get active classroom " . $name . " error");
		} catch (Exception $e) {
			LogRepository::fileSave($e);
		}

		return $queryPrep->fetchAll(PDO::FETCH_COLUMN)[0] ?? NULL;
	}

	public static function delete($name) {
		$db = dbConnect();

		$classroomId = ClassroomRepository::getId($name);

		// Delete classroom query
		$query = "UPDATE classroom SET name = 'deleted#" . $classroomId . "', updatedate = current_timestamp(), active = 0 WHERE id = :idclassroom";

		// Delete classroom
		try {
			$queryPrep = $db->prepare($query);
			$queryPrep->bindParam(":idclassroom", $classroomId);
			if ($queryPrep->execute())
				LogRepository::dbSave("Classroom " . $classroomId . " delete");
			else
				throw new Exception("Delete classroom " . $classroomId . " error");
		} catch (Exception $e) {
			LogRepository::fileSave($e);
		}
	}
}
