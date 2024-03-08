<?php
// Only get main url part
$page = explode("?", $_SERVER["REQUEST_URI"]);

switch ($page[0]) {
	case "/":
		include "page/index.php";
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
		include "page/register.php";
		break;
	case "/login":
		include "page/login.php";
		break;
	case "/sessions":
		include "page/session.php";
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
	case "/parametres":
		include "page/setting.php";
		break;
	case "/deconnexion":
		include "logic/disconnect.php";
		break;
	case "/connect":
		include "api/index.php";
		break;
	case "/denied":
		include "page/denied.php";
		break;
	default:
		include "page/notfound.php";
		break;
}
