<?php

namespace LabSupervisor\app\repository;
use PDO;
use Exception;
use LabSupervisor\app\entity\Session;

class SessionRepository {

	public function __construct() {}

	public function createSession(Session $entity) {
		if ($entity != NULL) {
			$bindParam = $entity->__toArray();
			// check if session doesn't exist
			if (!$this->getId($bindParam["title"])) {
				// Create session query
				$query = "INSERT INTO session (title, description, idcreator, date) VALUES (:title, :description, :idcreator, :date)";

				// Create session
				try {
					$queryPrep = DATABASE->prepare($query);
					$queryPrep->bindParam(":title", $bindParam["title"]);
					$queryPrep->bindParam(":description", $bindParam["description"]);
					$queryPrep->bindParam(":idcreator", $bindParam["idcreator"]);
					$queryPrep->bindParam(":date", $bindParam["date"]);
					if (!$queryPrep->execute())
						throw new Exception("Create session " . $bindParam["title"] . " error");
				} catch (Exception $e) {
					// Log error
					LogRepository::fileSave($e);
				}
			} else {
				// If session already exist
				$this->update($entity);
			}
		}
	}

	public function update(Session $entity) {
		$bindParam = $entity->__toArray();
		$sessionId = SessionRepository::getId($bindParam["title"]);

		// Update session query
		$query = "UPDATE session SET title = :title, description = :description, idcreator = :idcreator, date = :date WHERE id = :id";

		// Update session
		try {
			$queryPrep = DATABASE->prepare($query);
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
			// Log error
			LogRepository::fileSave($e);
		}
	}

	public static function getId($name) {
		// Get session ID query
		$query = "SELECT id FROM session WHERE title = :title";

		// Get session ID
		try {
			$queryPrep = DATABASE->prepare($query);
			$queryPrep->bindParam(':title', $name);
			if (!$queryPrep->execute())
				throw new Exception("Get session id " . $name . " error");
		} catch (Exception $e) {
			// Log error
			LogRepository::fileSave($e);
		}

		return $queryPrep->fetchAll(PDO::FETCH_COLUMN)[0] ?? NULL;
	}

	public static function getName($id) {
		// Get session name query
		$query = "SELECT title FROM session WHERE id = :id";

		// Get session name
		try {
			$queryPrep = DATABASE->prepare($query);
			$queryPrep->bindParam(':id', $id);
			if (!$queryPrep->execute())
				throw new Exception("Get session name " . $id . " error");
		} catch (Exception $e) {
			// Log error
			LogRepository::fileSave($e);
		}

		return $queryPrep->fetchAll(PDO::FETCH_COLUMN)[0] ?? NULL;
	}

	public static function getSessions() {
		// Get sessions query
		$query = "SELECT * FROM session";

		// Get sessions
		try {
			$queryPrep = DATABASE->prepare($query);
			if (!$queryPrep->execute())
				throw new Exception("Get sessions error");
		} catch (Exception $e) {
			// Log error
			LogRepository::fileSave($e);
		}

		return $queryPrep->fetchAll(PDO::FETCH_ASSOC) ?? NULL;
	}

	public static function getInfo($sessionId) {
		// Get session's datas query
		$query = "SELECT * FROM session WHERE id = :idsession";

		// Get session's datas
		try {
			$queryPrep = DATABASE->prepare($query);
			$queryPrep->bindParam(':idsession', $sessionId);
			if (!$queryPrep->execute())
				throw new Exception("Get session datas " . $sessionId . " error");
		} catch (Exception $e) {
			// Log error
			LogRepository::fileSave($e);
		}

		return $queryPrep->fetchAll(PDO::FETCH_ASSOC) ?? NULL;
	}

	public static function getStatus($chapterId, $userId) {
		// Get user's status query
		$query = "SELECT state FROM status WHERE idchapter = :idChapter AND iduser = :idUser";

		// Get user's status
		try {
			$queryPrep = DATABASE->prepare($query);
			$queryPrep->bindParam(':idChapter', $chapterId);
			$queryPrep->bindParam(':idUser', $userId);
			if (!$queryPrep->execute())
				throw new Exception("Get status chapter " . $chapterId . " for user " . UserRepository::getInfo($userId)["name"] . " error");
		} catch (Exception $e) {
			// Log error
			LogRepository::fileSave($e);
		}

		return $queryPrep->fetchAll(PDO::FETCH_COLUMN)[0] ?? NULL;
	}

	public static function getState($sessionId) {
		// Get if session is active query
		$query = "SELECT state FROM session WHERE id = :id";

		// Get if session is active
		try {
			$queryPrep = DATABASE->prepare($query);
			$queryPrep->bindParam(':id', $sessionId);
			if (!$queryPrep->execute())
				throw new Exception("Get state session " . $sessionId . " error");
		} catch (Exception $e) {
			// Log error
			LogRepository::fileSave($e);
		}

		return $queryPrep->fetchAll(PDO::FETCH_COLUMN)[0] ?? NULL;
	}

	public static function getChapter($sessionId) {
		// Get session's chapter query
		$query = "SELECT id, title, description FROM chapter WHERE idsession = :idsession";

		// Get session's chapter
		try {
			$queryPrep = DATABASE->prepare($query);
			$queryPrep->bindParam(':idsession', $sessionId);
			if (!$queryPrep->execute())
				throw new Exception("Get chapter from session " . $sessionId . " error");
		} catch (Exception $e) {
			// Log error
			LogRepository::fileSave($e);
		}

		return $queryPrep->fetchAll(PDO::FETCH_ASSOC) ?? NULL;
	}

	public static function getSessionStatus($userId, $sessionId) {
		// Get session's chapter query
		$query = "SELECT state FROM status WHERE iduser = :idUser AND idsession = :idSession";

		// Get session's chapter
		try {
			$queryPrep = DATABASE->prepare($query);
			$queryPrep->bindParam(':idUser', $userId);
			$queryPrep->bindParam(':idSession', $sessionId);
			if (!$queryPrep->execute())
				throw new Exception("Get state from user " . $userId . " error");
		} catch (Exception $e) {
			// Log error
			LogRepository::fileSave($e);
		}

		return $queryPrep->fetchAll(PDO::FETCH_COLUMN) ?? NULL;
	}

	public static function getChapterId($chapter) {
		// Get chapter id query
		$query = "SELECT id FROM chapter WHERE title = :title";

		// Get chapter id
		try {
			$queryPrep = DATABASE->prepare($query);
			$queryPrep->bindParam(':title', $chapter);
			if (!$queryPrep->execute())
				throw new Exception("Get chapter id " . $chapter . " error");
		} catch (Exception $e) {
			// Log error
			LogRepository::fileSave($e);
		}

		return $queryPrep->fetchAll(PDO::FETCH_COLUMN)[0] ?? NULL;
	}

	public static function getParticipant($sessionId) {
		$whitelistRole = STUDENT;

		// Get session's participants query
		$query = "SELECT p.iduser FROM participant p, userrole rl WHERE p.idsession = :idsession AND rl.iduser = p.iduser AND rl.idrole = :idrole";

		// Get session's participant
		try {
			$queryPrep = DATABASE->prepare($query);
			$queryPrep->bindParam(':idsession', $sessionId);
			$queryPrep->bindParam(':idrole', $whitelistRole);
			if (!$queryPrep->execute())
				throw new Exception("Get participant from session " . $sessionId . " error");
		} catch (Exception $e) {
			// Log error
			LogRepository::fileSave($e);
		}

		return $queryPrep->fetchAll(PDO::FETCH_ASSOC) ?? NULL;
	}

	public static function getUserSessions($email) {
		$userId = UserRepository::getId($email);

		// Get user's sessions query
		$query = "SELECT idsession FROM participant WHERE iduser = :iduser";

		// Get user's sessions
		try {
			$queryPrep = DATABASE->prepare($query);
			$queryPrep->bindParam(':iduser', $userId);
			if (!$queryPrep->execute())
				throw new Exception("Get sessions from user " . $userId . " error");
		} catch (Exception $e) {
			// Log error
			LogRepository::fileSave($e);
		}

		return $queryPrep->fetchAll(PDO::FETCH_ASSOC) ?? NULL;
	}

	public static function addChapter($name, $description, $creatorId, $sessionName) {
		$sessionId = SessionRepository::getId($sessionName);

		// Add chapter query
		$query = "INSERT INTO chapter (idsession, title, description, idcreator) VALUES (:idsession, :title, :description, :idcreator)";

		// Add chapter
		try {
			$queryPrep = DATABASE->prepare($query);
			$queryPrep->bindParam(':idsession', $sessionId);
			$queryPrep->bindParam(':title', $name);
			$queryPrep->bindParam(':description', $description);
			$queryPrep->bindParam(':idcreator', $creatorId);
			if ($queryPrep->execute())
				LogRepository::dbSave("Add chapter " . $creatorId);
			else
				throw new Exception("Add chapter " . $creatorId . " error");
		} catch (Exception $e) {
			// Log error
			LogRepository::fileSave($e);
		}
	}

	public static function addParticipant($participantId, $sessionName) {
		$sessionId = SessionRepository::getId($sessionName);

		// Add participant query
		$query = "INSERT INTO participant (iduser, idsession) VALUES (:iduser, :idsession)";

		// Add participant
		try {
			$queryPrep = DATABASE->prepare($query);
			$queryPrep->bindParam(':iduser', $participantId);
			$queryPrep->bindParam(':idsession', $sessionId);
			if ($queryPrep->execute())
				LogRepository::dbSave("Add participant " . $participantId);
			else
				throw new Exception("Add participant " . $participantId . " error");
		} catch (Exception $e) {
			// Log error
			LogRepository::fileSave($e);
		}
	}

	public static function addStatus($sessionId, $chapterId, $userId) {
		// Add status query
		$query = "INSERT INTO status (idsession, idchapter, iduser) VALUES (:idsession, :idchapter, :iduser)";

		// Add status
		try {
			$queryPrep = DATABASE->prepare($query);
			$queryPrep->bindParam(":idsession", $sessionId);
			$queryPrep->bindParam(":idchapter", $chapterId);
			$queryPrep->bindParam(":iduser", $userId);

			if ($queryPrep->execute())
				LogRepository::dbSave("Add status to chapter " . $chapterId . " for " . $userId);
			else
				throw new Exception("Add status to chapter " . $chapterId . " for " . $userId . " error");
		} catch (Exception $e) {
			// Log error
			LogRepository::fileSave($e);
		}
	}

	public static function setStatus($sessionId, $chapterId, $userId, $state) {
		// Set status query
		$query = "UPDATE status SET state = :idStatus WHERE idchapter = :idChapter AND iduser = :idUser AND idsession = :idSession";

		// Set status
		try {
			$queryPrep = DATABASE->prepare($query);
			$queryPrep->bindParam(':idUser', $userId);
			$queryPrep->bindParam(':idSession', $sessionId);
			$queryPrep->bindParam(':idChapter', $chapterId);
			$queryPrep->bindParam(':idStatus', $state);
			if ($queryPrep->execute())
				LogRepository::dbSave("Update status to " . $state . " from session " . $sessionId);
			else
				throw new Exception("Status " . $state . " from session " . $sessionId . " update error");
		} catch (Exception $e) {
			// Log error
			LogRepository::fileSave($e);
		}
	}

	public static function state($sessionId, $state) {
		// Update session state query
		$query = "UPDATE session SET state = :state WHERE id = :idSession";

		// Update session state
		try {
			$queryPrep = DATABASE->prepare($query);
			$queryPrep->bindParam(':idSession', $sessionId);
			$queryPrep->bindParam(':state', $state);
			if ($queryPrep->execute())
				LogRepository::dbSave("Update session " . $sessionId . " state");
			else
				throw new Exception("Update session " . $sessionId . " state error");
		} catch (Exception $e) {
			// Log error
			LogRepository::fileSave($e);
		}
	}

	public static function setState($sessionId, $state) {
		// Set status query
		$query = "UPDATE session SET state = :state WHERE id = :idSession";

		// Set status
		try {
			$queryPrep = DATABASE->prepare($query);
			$queryPrep->bindParam(':idSession', $sessionId);
			$queryPrep->bindParam(':state', $state);
			if ($queryPrep->execute())
				LogRepository::dbSave("Update state of " . $sessionId);
			else
				throw new Exception("State " . $sessionId . " update error");
		} catch (Exception $e) {
			// Log error
			LogRepository::fileSave($e);
		}
	}

	public static function delete($name) {
		$sessionId = SessionRepository::getId($name);

		// Delete session query
		$query = "UPDATE session SET title = 'deleted#" . $sessionId . "', active = 0 WHERE id = :idsession";

		// Delete session
		try {
			$queryPrep = DATABASE->prepare($query);
			$queryPrep->bindParam(":idsession", $sessionId);
			if ($queryPrep->execute())
				LogRepository::dbSave("Session " . $sessionId . " delete");
			else
				throw new Exception("Delete session " . $sessionId . " error");
		} catch (Exception $e) {
			// Log error
			LogRepository::fileSave($e);
		}
	}
}
