<?php

if (isset($_POST["status"])) {
	SessionRepository::setStatus($_SESSION["session"], $_POST['chapter'], UserRepository::getId($_SESSION["login"]), $_POST['status']);
}
