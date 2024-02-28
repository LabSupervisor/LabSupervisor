<?php

class SessionRepository {

	public function __construct() {}

	public function createSession(Session $entity) {
        if ($entity != NULL) {
            $bindParam = $entity->__toArray();
			// check if session doesn't exist
			if (!$this->getId($bindParam["title"])) {
				$db = dbConnect();

				// Create session query
				$query = "INSERT INTO session (title, description, idcreator, date) VALUES (:title, :description, :idcreator, :date)";

				// Create session
				try {
					$queryPrep = $db->prepare($query);
					$queryPrep->bindParam(":title", $bindParam["title"]);
					$queryPrep->bindParam(":description", $bindParam["description"]);
					$queryPrep->bindParam(":idcreator", $bindParam["idcreator"]);
					$queryPrep->bindParam(":date", $bindParam["date"]);
					if (!$queryPrep->execute())
						throw new Exception("Create session " . $bindParam["title"] . " error");
				} catch (Exception $e) {
					LogRepository::fileSave($e);
				}
			} else {
				// If session already exist
				$this->update($entity);
			}
		}
	}

	public function update(Session $entity) {
		$db = dbConnect();

		$bindParam = $entity->__toArray();
		$sessionId = SessionRepository::getId($bindParam["title"]);

		// Update user query
		$query = "UPDATE session SET title = :title, description = :description, idcreator = :idcreator, date = :date, updatedate = current_timestamp() WHERE id = :id";

		// Update user
		try {
			$queryPrep = $db->prepare($query);
			$queryPrep->bindParam(":title", $bindParam["title"]);
			$queryPrep->bindParam(":description", $bindParam["description"]);
			$queryPrep->bindParam(":idcreator", $bindParam["idcreator"]);
			$queryPrep->bindParam(":date", $bindParam["date"]);
			$queryPrep->bindParam(":id", $sessionId);
			if ($queryPrep->execute())
				LogRepository::dbSave("Update session " . $bindParam["title"]);
			else
				throw new Exception("Update session " . $bindParam["title"] . " error");
		} catch (Exception $e) {
			LogRepository::fileSave($e);
		}
	}

	public static function getId($name) {
		$db = dbConnect();

		// Get user ID query
		$query = "SELECT id FROM session WHERE title = :title";

		// Get user ID
		try {
			$queryPrep = $db->prepare($query);
			$queryPrep->bindParam(':title', $name);
			if (!$queryPrep->execute())
				throw new Exception("Get session id " . $name . " error");
		} catch (Exception $e) {
			LogRepository::fileSave($e);
		}

		return $queryPrep->fetchAll(PDO::FETCH_COLUMN)[0] ?? NULL;
	}

	public static function getInfo($sessionId) {
		$db = dbConnect();

		// Get user ID query
		$query = "SELECT * FROM session WHERE id = :idsession";

		// Get user ID
		try {
			$queryPrep = $db->prepare($query);
			$queryPrep->bindParam(':idsession', $sessionId);
			if (!$queryPrep->execute())
				throw new Exception("Get session datas " . $sessionId . " error");
		} catch (Exception $e) {
			LogRepository::fileSave($e);
		}

		return $queryPrep->fetchAll(PDO::FETCH_ASSOC) ?? NULL;
	}

	public static function getStatus($chapter, $userId) {
		$db = dbConnect();

		// Get user status query
		$query = "SELECT state FROM status WHERE idchapter = :idChapter AND iduser = :idUser";

		// Get user status
		try {
			$queryPrep = $db->prepare($query);
			$queryPrep->bindParam(':idChapter', $chapter);
			$queryPrep->bindParam(':idUser', $userId);
			if (!$queryPrep->execute())
				throw new Exception("Get status chapter " . $chapter . " for user " . UserRepository::getInfo($userId)["name"] . " error");
		} catch (Exception $e) {
			LogRepository::fileSave($e);
		}

		return $queryPrep->fetchAll(PDO::FETCH_COLUMN)[0] ?? NULL;
	}

	public static function getChapter($sessionId) {
		$db = dbConnect();

		// Get user status query
		$query = "SELECT id, title, description FROM chapter WHERE idsession = :idsession";

		// Get user status
		try {
			$queryPrep = $db->prepare($query);
			$queryPrep->bindParam(':idsession', $sessionId);
			if (!$queryPrep->execute())
				throw new Exception("Get chapter from session " . $sessionId . " error");
		} catch (Exception $e) {
			LogRepository::fileSave($e);
		}

		return $queryPrep->fetchAll(PDO::FETCH_ASSOC) ?? NULL;
	}

	public static function getParticipant($sessionId) {
		$db = dbConnect();

		// Get user status query
		$query = "SELECT us.name, us.surname, ch.title, st.state FROM user us, status st, session s, chapter ch WHERE us.id = st.iduser AND s.id = :idsession AND s.id = st.idsession AND ch.idsession = s.id AND st.idchapter = ch.id ORDER BY us.name ASC";

		// Get user status
		try {
			$queryPrep = $db->prepare($query);
			$queryPrep->bindParam(':idsession', $sessionId);
			if (!$queryPrep->execute())
				throw new Exception("Get participant from session " . $sessionId . " error");
		} catch (Exception $e) {
			LogRepository::fileSave($e);
		}

		return $queryPrep->fetchAll(PDO::FETCH_ASSOC) ?? NULL;
	}

	public static function getUserSessions($email) {
		$db = dbConnect();

		$userId = UserRepository::getId($email);

		// Get user status query
		$query = "SELECT idsession FROM participant WHERE iduser = :iduser";

		// Get user status
		try {
			$queryPrep = $db->prepare($query);
			$queryPrep->bindParam(':iduser', $userId);
			if (!$queryPrep->execute())
				throw new Exception("Get sessions from user " . $userId . " error");
		} catch (Exception $e) {
			LogRepository::fileSave($e);
		}

		return $queryPrep->fetchAll(PDO::FETCH_ASSOC) ?? NULL;
	}

	public static function addChapter($name, $description, $creatorId, $sessionName) {
		$db = dbConnect();

		$sessionId = SessionRepository::getId($sessionName);

		// Add chapter query
		$query = "INSERT INTO chapter (idsession, title, description, idcreator) VALUES (:idsession, :title, :description, :idcreator)";

		// Add chapter
		try {
			$queryPrep = $db->prepare($query);
			$queryPrep->bindParam(':idsession', $sessionId);
			$queryPrep->bindParam(':title', $name);
			$queryPrep->bindParam(':description', $description);
			$queryPrep->bindParam(':idcreator', $creatorId);
			if ($queryPrep->execute())
				LogRepository::dbSave("Add chapter " . $creatorId);
			else
				throw new Exception("Add chapter " . $creatorId . " error");
		} catch (Exception $e) {
			LogRepository::fileSave($e);
		}
	}

	public static function addParticipant($participantId, $sessionName) {
		$db = dbConnect();

		$sessionId = SessionRepository::getId($sessionName);

		// Add chapter query
		$query = "INSERT INTO participant (iduser, idsession) VALUES (:iduser, :idsession)";

		// Add chapter
		try {
			$queryPrep = $db->prepare($query);
			$queryPrep->bindParam(':iduser', $participantId);
			$queryPrep->bindParam(':idsession', $sessionId);
			if ($queryPrep->execute())
				LogRepository::dbSave("Add participant " . $participantId);
			else
				throw new Exception("Add participant " . $participantId . " error");
		} catch (Exception $e) {
			LogRepository::fileSave($e);
		}
	}

	public static function isActive($name) {
		$db = dbConnect();

		// Get session ID query
		$query = "SELECT active FROM session WHERE title = :title";

		// Get session ID
		try {
			$queryPrep = $db->prepare($query);
			$queryPrep->bindParam(':title', $name);
			if (!$queryPrep->execute())
				throw new Exception("Get active session " . $name . " error");
		} catch (Exception $e) {
			LogRepository::fileSave($e);
		}

		return $queryPrep->fetchAll(PDO::FETCH_COLUMN)[0] ?? NULL;
	}

	public static function delete($name) {
		$db = dbConnect();

		$sessionId = SessionRepository::getId($name);

		// Delete session query
		$query = "UPDATE session SET title = 'deleted#" . $sessionId . "', updatedate = current_timestamp(), active = 0 WHERE id = :idsession";

		// Delete session
		try {
			$queryPrep = $db->prepare($query);
			$queryPrep->bindParam(":idsession", $sessionId);
			if ($queryPrep->execute())
				LogRepository::dbSave("Session " . $sessionId . " delete");
			else
				throw new Exception("Delete session " . $sessionId . " error");
		} catch (Exception $e) {
			LogRepository::fileSave($e);
		}
	}
}
