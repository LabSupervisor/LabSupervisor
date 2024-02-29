<?php

require($_SERVER['DOCUMENT_ROOT'] . '/logic/ft_header.php');
mainHeader("User Test");

$userRepo = new UserRepository();

$userData = array(
	"email" => "test@test.com",
	"name" => "test",
	"surname" => "test",
	"password" => "test",
	"birthDate" => "2023-01-11"
);

$user = new User($userData);
$userRepo->createUser($user);

echo "<br>" . $userRepo->getId($_SESSION["login"]);
echo "<br>" . UserRepository::getId($_SESSION["login"]);
echo "<br>" . UserRepository::isActive($_SESSION["login"]);

echo "<form method='post'><input type='hidden' name='email' value='" . $_SESSION["login"] . "'><input type='submit' name='delete' value='Delete'/></form>";

if (isset($_POST["delete"])) {
	UserRepository::delete($_POST["email"]);
	header("Location: /");
}
