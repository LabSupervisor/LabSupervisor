<?php

require($_SERVER["DOCUMENT_ROOT"] . '/function/ft_header.php');
mainHeader("Session Test");

$sessionRepo = new SessionRepository();

$sessionData = array(
	"title" => "test",
	"description" => "test",
	"idcreator" => UserRepository::getId($_SESSION["login"]),
	"date" => "1970-01-01 00:00:00"
);

$session = new Session($sessionData);
$sessionRepo->createSession($session);

echo "<br>" . SessionRepository::getId($sessionData["title"]);
echo "<br>" . SessionRepository::getState(SessionRepository::getId($sessionData["title"]));

echo "<form method='post'><input type='hidden' name='title' value='" . $sessionData["title"] . "'><input type='submit' name='delete' value='Delete'/></form>";

if (isset($_POST["delete"])) {
	SessionRepository::delete($_POST["title"]);
	header("Location: /");
}
