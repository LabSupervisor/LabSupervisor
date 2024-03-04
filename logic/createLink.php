<?php

if (isset($_POST["link"])) {
	UserRepository::link(UserRepository::getId($_SESSION["login"]), $_POST["number"]);
	header("Location: /panel");
}
