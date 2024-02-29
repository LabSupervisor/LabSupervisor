<?php
	$page = explode("?", $_SERVER["REQUEST_URI"]);

	switch ($page[0]) {
		case "/":
			include "pages/index.php";
			break;
		case "/compte":
			include "pages/account.php";
			break;
		case "/dashboard":
			include "pages/dashboard.php";
			break;
		case "/log":
			include "pages/log.php";
			break;
		case "/register":
			include "pages/register.php";
			break;
		case "/login":
			include "pages/login.php";
			break;
		case "/sessions":
			include "pages/session.php";
			break;
		case "/sessioncreation":
			include "pages/sessioncreation.php";
			break;
		case "/utilisateurs":
			include "pages/user.php";
			break;
		case "/classes":
			include "pages/classroom.php";
			break;
		case "/panel":
			include "pages/sessionpanel.php";
			break;
		case "/parametres":
			include "pages/setting.php";
			break;
		case "/deconnexion":
			include "logic/disconnect.php";
			break;
		case "/denied":
			include "pages/denied.php";
			break;
		default:
			include "pages/notfound.php";
			break;
	}
?>
