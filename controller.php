<?php

// Import application
require($_SERVER["DOCUMENT_ROOT"] . "/config/config.php");

// Only get main url part
$page = explode("?", $_SERVER["REQUEST_URI"]);

switch ($page[0]) {
	case "/":
		if (isset($_SESSION["login"]))
			include "page/index.php";
		else
			header("Location: /login");
		break;
	case "/compte":
		include "page/account.php";
		break;
	case "/dashboard":
		include "page/dashboard.php";
		break;
	case "/logs":
		include "page/log.php";
		break;
	case "/register":
		if ($_ENV["AUTHENTIFICATION_TYPE"] == "native") {
			include "page/register.php";
		} else {
			include "page/notfound.php";
		}
		break;
	case "/login":
		include "page/login.php";
		break;
	case "/sessions":
		include "page/session.php";
		break;
	case "/sessionmodifier":
		include "page/sessioncreation.php";
		break;
	case "/sessioncreation":
		include "page/sessioncreation.php";
		break;
	case "/utilisateurs":
		include "page/user.php";
		break;
	case "/classes":
		include "page/classroom.php";
		break;
	case "/panel":
		include "page/sessionpanel.php";
		break;
	case "/deconnexion":
		include "logic/disconnect.php";
		break;
	case "/connect":
		include "api/index.php";
		break;
	// This is not a debug.
	case "/helloworld":
		echo "<h1>Hello world!</h1>";
		break;
	case "/screenshare":
		include "page/screenshare.php";
		break;
	case "/denied":
		include "page/denied.php";
		break;
	default:
		include "page/notfound.php";
		break;
}
