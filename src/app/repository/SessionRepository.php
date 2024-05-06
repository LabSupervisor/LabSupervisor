<?php

namespace LabSupervisor\app\repository;
use
	PDO,
	Exception,
	LabSupervisor\app\entity\Session;

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
		// $sessionId = SessionRepository::getId($bindParam["title"]);

		// Update session query
		$query = "UPDATE session SET title = :title, description = :description, idcreator = :idcreator, date = :date WHERE id = :id";

		// Update session
		try {
			$queryPrep = DATABASE->prepare($query);
			$queryPrep->bindParam(":title", $bindParam["title"]);
			$queryPrep->bindParam(":description", $bindParam["description"]);
			$queryPrep->bindParam(":idcreator", $bindParam["idcreator"]);
			$queryPrep->bindParam(":date", $bindParam["date"]);
			$queryPrep->bindParam(":id", $bindParam["id"]);
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

	public static function getActiveChapter($sessionId) {

		// Get session's chapter query
		$query = "SELECT id, title, description FROM chapter WHERE idsession = :idsession AND active = 1";
		// Get session's chapter
		try {
			$queryPrep = DATABASE->prepare($query);
			$queryPrep->bindParam(':idsession', $sessionId);
			if (!$queryPrep->execute())
				throw new Exception("Get active chapter from session " . $sessionId . " error");
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

	public static function getParticipants($sessionId, $full = false) {
		// Get session's participants query
		$query = "SELECT p.iduser FROM participant p, user us WHERE p.idsession = :idsession AND us.id = p.iduser ORDER BY surname ASC";

		// Get session's participant
		try {
			$queryPrep = DATABASE->prepare($query);
			$queryPrep->bindParam(':idsession', $sessionId);
			if (!$queryPrep->execute())
				throw new Exception("Get participant from session " . $sessionId . " error");
		} catch (Exception $e) {
			// Log error
			LogRepository::fileSave($e);
		}

		return $queryPrep->fetchAll(PDO::FETCH_ASSOC) ?? NULL;
	}

	public static function getUserSessions($userId) {

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

	public static function updateChapter($name, $description, $creatorId, $chapterId) {
		// Update chapter query
		$query = "UPDATE chapter SET title = :title, description = :description, idcreator = :idcreator WHERE id = :id ";

		try {
			$queryPrep = DATABASE->prepare($query);
			$queryPrep->bindParam(':title', $name);
			$queryPrep->bindParam(':description', $description);
			$queryPrep->bindParam(':idcreator', $creatorId);
			$queryPrep->bindParam(':id', $chapterId );

			if ($queryPrep->execute())
				LogRepository::dbSave("update chapter " .$chapterId ."with creator". $creatorId);
			else
				throw new Exception("update chapter " . $chapterId . " error");
		} catch (Exception $e) {
			// Log error
			LogRepository::fileSave($e);
		}
	}

	public static function delete($sessionId) {
		// Delete session query
		$query = "DELETE FROM session WHERE id = :idsession";

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

	public static function deleteParticipant($sessionId, $userId) {
		// Delete session participant query
		$query = "DELETE FROM participant WHERE idsession = :idsession AND iduser = :iduser";

		// Delete session participant
		try {
			$queryPrep = DATABASE->prepare($query);
			$queryPrep->bindParam(":idsession", $sessionId);
			$queryPrep->bindParam(":iduser", $userId);
			if ($queryPrep->execute())
				LogRepository::dbSave("Session " . $sessionId . " participant " . $userId . " delete");
			else
				throw new Exception("Delete session " . $sessionId . " participant " . $userId . " error");
		} catch (Exception $e) {
			// Log error
			LogRepository::fileSave($e);
		}
	}

	public static function deleteStatus($sessionId, $userId, $chapterId) {
		// Delete session participant status query
		$query = "DELETE FROM status WHERE idsession = :idsession AND iduser = :iduser AND idchapter = :idchapter";

		// Delete session status participant
		try {
			$queryPrep = DATABASE->prepare($query);
			$queryPrep->bindParam(":idsession", $sessionId);
			$queryPrep->bindParam(":iduser", $userId);
			$queryPrep->bindParam(":idchapter", $chapterId);
			if ($queryPrep->execute())
				LogRepository::dbSave("Session " . $sessionId . " status " . $userId . " chapter " . $chapterId . " delete");
			else
				throw new Exception("Delete session " . $sessionId . " status " . $userId . " chapter " . $chapterId . " error");
		} catch (Exception $e) {
			// Log error
			LogRepository::fileSave($e);
		}
	}

	public static function deleteChapter($chapterId){
		// Delete chapter query
		$query = "DELETE FROM chapter WHERE id = :idchapter";

		// Delete chapter
		try {
			$queryPrep = DATABASE->prepare($query);
			$queryPrep->bindParam(":idchapter", $chapterId);
			if ($queryPrep->execute())
				LogRepository::dbSave("Chapitre " . $chapterId . " delete");
			else
				throw new Exception("Delete chapitre " . $chapterId . " error");
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

	public static function addChapter($name, $description, $creatorId, $sessionId) {

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

	public static function setState($sessionId, $state) {
		// Set state query
		$query = "UPDATE session SET state = :state WHERE id = :idSession";

		// Set state
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
}
