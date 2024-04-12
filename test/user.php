<?php

use LabSupervisor\app\repository\UserRepository;
use LabSupervisor\app\entity\User;
use function LabSupervisor\functions\mainHeader;

mainHeader("User Test");

$userRepo = new UserRepository();

$userData = array(
	"email" => "test@test.com",
	"name" => "test",
	"surname" => "test",
	"password" => "test"
);

$user = new User($userData);
$userRepo->createUser($user);

$_SESSION["login"] = $userData["email"];

echo "<br>" . $userRepo->getId($_SESSION["login"]);
echo "<br>" . UserRepository::getId($_SESSION["login"]);
echo "<br>" . UserRepository::isActive($_SESSION["login"]);

echo "<form method='post'><input type='hidden' name='email' value='" . $_SESSION["login"] . "'><input type='submit' name='delete' value='Delete'/></form>";

if (isset($_POST["delete"])) {
	UserRepository::delete($_POST["email"]);
	header("Location: /");
}
