<?php

use LabSupervisor\app\repository\SessionRepository;
use LabSupervisor\app\entity\Session;
use LabSupervisor\app\repository\ClassroomRepository;
use LabSupervisor\app\repository\UserRepository;

use function LabSupervisor\functions\lang;

// Case 1 : save all infos in order to create a new session
if (isset($_POST['saveSession'])) {
    $sessionRepo = new SessionRepository();

    $title = $_POST['titleSession'];
    $description = $_POST['descriptionSession'];
    $classroomId = $_POST['classes'];
    $creatorId = $_SESSION['login'];
    $date = $_POST['date'];

    $sessionData = [
        'title'       => $title,
        'description' => $description,
        'idclassroom' => $classroomId,
        'idcreator'   => $creatorId,
        'date'        => $date,
    ];

    // Create session
    $session = new Session($sessionData);
    $sessionRepo->createSession($session);
    $sessionId = SessionRepository::getId($title);

    $classUsers = ClassroomRepository::getUsers($classroomId);

    // Add participants
    foreach ($classUsers as $user) {
        SessionRepository::addParticipant($user['iduser'], $sessionId);
    }

    if (isset($_POST['addChapters'])) {
        $addChapters = $_POST['addChapters'];
        foreach ($addChapters as $addChapter) {
            SessionRepository::addChapter($addChapter['title'], $addChapter['desc'], $creatorId, $sessionId);
        }

        $idChaptersNoStatus = SessionRepository::getChapterNoStatus($sessionId);
        foreach ($classUsers as $user) {
            foreach ($idChaptersNoStatus as $value) {
                SessionRepository::addStatus($sessionId, $value['chapterId'], $user['iduser']);
            }
        }
    }

    // Add teacher to his own session
    SessionRepository::addParticipant($_SESSION['login'], $sessionId);

    // Add other teacher
    // SessionRepository::addParticipant();

    if (isset($_POST['state'])) {
        SessionRepository::setState($sessionId, 1);
    }

    setcookie('notification', lang('SESSION_CREATE_NOTIFICATION'), 0);

    header('Location: /sessions');
} elseif (isset($_POST['updateSession'])) {
    // Case 2 : update an existing session after the user pressed the 'Update' button
    $sessionRepo = new SessionRepository();

    $title = $_POST['titleSession'];
    $description = $_POST['descriptionSession'];
    $classroomId = $_POST['classes'];
    $creatorId = $_SESSION['login'];
    $date = $_POST['date'];
    $sessionId = $_POST['idSession'];
    // This is an array containing the iduser of the selected teachers
    $selectedTeachers = isset($_POST['teacher']) === true ? $_POST['teacher'] : [];
    // Array containing the if of the teachers to be removed
    $removedTeachers = isset($_POST['removedTeachers']) === true ? $_POST['removedTeachers'] : [];

    $sessionData = [
        'title'       => $title,
        'description' => $description,
        'idclassroom' => $classroomId,
        'idcreator'   => $creatorId,
        'date'        => $date,
        'id'          => $sessionId,
    ];

    // update session
    $session = new Session($sessionData);
    $sessionRepo->update($session);

    foreach (SessionRepository::getParticipants($sessionId) as $user) {
        UserRepository::unlink($user['iduser'], $sessionId, UserRepository::getLink($user['iduser'], $sessionId));
    }

    // Add participants
    $classUsers = ClassroomRepository::getUsers($classroomId);

    // Add other teacher
    foreach ($selectedTeachers as $teacherId) {
        SessionRepository::addParticipant($teacherId, $sessionId);
    }

    // Remove teacher
    foreach ($removedTeachers as $teacherId) {
        SessionRepository::deleteParticipant($sessionId, $teacherId);
    }

    if (isset($_POST['classroomChange'])) {
        // Remove participants
        foreach (SessionRepository::getParticipants($sessionId) as $user) {
            foreach (SessionRepository::getChapter($sessionId) as $value) {
                SessionRepository::deleteStatus($sessionId, $user['iduser'], $value['id']);
            }
            UserRepository::unlink($user['iduser'], $sessionId, UserRepository::getLink($user['iduser'], $sessionId));
            SessionRepository::deleteParticipant($sessionId, $user['iduser']);
        }

        // Add participants
        $classUsers = ClassroomRepository::getUsers($classroomId);
        foreach ($classUsers as $userId) {
            SessionRepository::addParticipant($userId['iduser'], $sessionId);
        }
        foreach (SessionRepository::getChapter($sessionId) as $chapterId) {
            foreach ($classUsers as $userId) {
                SessionRepository::addStatus($sessionId, $chapterId['id'], $userId['iduser']);
            }
        }

        // Add teacher to his own session
        SessionRepository::addParticipant($creatorId, $sessionId);
    }

    if (isset($_POST['addChapters'])) {
        $addChapters = $_POST['addChapters'];
        foreach ($addChapters as $addChapter) {
            SessionRepository::addChapter($addChapter['title'], $addChapter['desc'], $creatorId, $sessionId);
        }

        $idChaptersNoStatus = SessionRepository::getChapterNoStatus($sessionId);
        foreach ($classUsers as $user) {
            foreach ($idChaptersNoStatus as $value) {
                SessionRepository::addStatus($sessionId, $value['chapterId'], $user['iduser']);
            }
        }
    }

    if (isset($_POST['updatedChapters'])) {
        $updatedChapters = $_POST['updatedChapters'];
        foreach ($updatedChapters as $updatedChapter) {
            SessionRepository::updateChapter($updatedChapter['title'], $updatedChapter['desc'], $creatorId, $updatedChapter['id']);
        }
    }

    if (isset($_POST['deletedChapters'])) {
        $deletededChapters = $_POST['deletedChapters'];
        $participant = SessionRepository::getParticipants($sessionId);

        foreach ($participant as $user) {
            foreach ($deletededChapters as $value) {
                SessionRepository::deleteStatus($sessionId, $user['iduser'], $value);
            }
        }

        foreach ($deletededChapters as $deletedChapter) {
            SessionRepository::deleteChapter($deletedChapter);
        }
    }

    if (isset($_POST['state'])) {
        if (SessionRepository::getState($sessionId) == 0) {
            SessionRepository::setState($sessionId, 1);
        }
    } else {
        SessionRepository::setState($sessionId, 0);
    }

    $_POST['sessionId'] = $sessionId;
} elseif (isset($_POST['sessionId'])) {
    // Case 3 : prefill the session form with session data
    $sessionRepo = new SessionRepository();
    $sessionInfo = SessionRepository::getInfo($_POST['sessionId']);
    $sessionData = [
        'title'       => $sessionInfo[0]['title'],
        'description' => $sessionInfo[0]['description'],
        'idcreator'   => $sessionInfo[0]['idcreator'],
        'date'        => $sessionInfo[0]['date'],
        'idSession'   => $sessionInfo[0]['id'],
    ];
    $session = new Session($sessionData);
} elseif (isset($_POST['deleteSession'])) {
    // Case 4 : delete an existing session after the user pressed the 'Delete' button
    $sessionId = $_POST['deleteSession'];
    $participant = SessionRepository::getParticipants($sessionId);
    $chapter = SessionRepository::getChapter($sessionId);

    foreach ($participant as $user) {
        foreach ($chapter as $value) {
            SessionRepository::deleteStatus($sessionId, $user['iduser'], $value['id']);
        }
        UserRepository::removeScreenshare(UserRepository::getScreenshare($user['iduser'], $sessionId), $sessionId);
        UserRepository::unlink($user['iduser'], $sessionId, UserRepository::getLink($user['iduser'], $sessionId));
        SessionRepository::deleteParticipant($sessionId, $user['iduser']);
    }

    foreach ($chapter as $value) {
        SessionRepository::deleteChapter($value['id']);
    }


    SessionRepository::delete($sessionId);

    setcookie('notification', lang('SESSION_CREATE_DELETE_NOTIFICATION'), 0);

    header('Location: /sessions');
}
