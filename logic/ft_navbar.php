<body>
	<nav class="navbar">
		<div class="logo-container left">
			<?php
				// Icon path
				$cheminImage = "http://" . $_SERVER["SERVER_NAME"] . "/public/img/logo.ico";
				echo "<img src=" . $cheminImage . "></img>";
			?>
		</div>
			<a class="bold title left no-hover-color">LabSupervisor</a>
				<ul>
					<li>
						<a class="title bold" href="<?="http://" . $_SERVER["SERVER_NAME"]?>"><i class="ri-home-line"></i> Accueil</a>
					</li>
		<?php
			// Check if user is connected
			if (!isset($_SESSION["login"])) { ?>
					<li>
						<a class="title bold" href="<?="http://" . $_SERVER["SERVER_NAME"] . "/pages/login.php"?>"><i class="ri-user-line"></i> Connexion</a>
					</li>
				</ul>
			</nav>
		<?php
			// If the user is connected
			} else {
				$roleList = permissionChecker(true, true, true);
			// If the user is a teacher
			if (in_array("teacher", $roleList)) { ?>
					<li>
						<a class="title bold" href="#"><i class="ri-folder-line"></i> Classes</a>
					</li>
					<li>
						<a class="title bold" href="<?="http://" . $_SERVER["SERVER_NAME"] . "/pages/sessioncreation.php"?>"><i class="ri-computer-line"></i> Créer une session</a>
					</li>
					<li>
						<a class="title bold" href="<?="http://" . $_SERVER["SERVER_NAME"] . "/pages/session.php"?>"><i class="ri-slideshow-3-line"></i> Voir mes sessions</a>
					</li>
		<?php }
			// If the user is a student
			else if(in_array("student", $roleList)) { ?>
				<li>
					<a class="title bold" href="<?="http://" . $_SERVER["SERVER_NAME"] . "/pages/session.php"?>"><i class="ri-slideshow-3-line"></i> Voir mes sessions</a>
				</li>
		<?php }
			// If the user is an admin
			else if (in_array("admin", $roleList)) { ?>
				<li>
					<a class="title bold" href="#"><i class="ri-folder-line"></i> Classes</a>
				</li>
				<li>
					<a class="title bold" href="#"><i class="ri-slideshow-3-line"></i> Sessions</a>
				</li>
				<li>
					<a class="title bold" href="<?="http://" . $_SERVER["SERVER_NAME"] . "/pages/log.php?trace"?>"><i class="ri-computer-line"></i> Logs</a>
				</li>
		<?php
			}
			// Profil part if connected
		?>
			<?php
				$username = getName(getUserId($_SESSION["login"]));
			?>
			<li><a class="title bold case" href="#"><i class="ri-user-line"></i> <?=$username?></a>
				<ul class="sub">
					<li>
						<a class="title bold" href="<?="http://" . $_SERVER["SERVER_NAME"] . "/pages/account.php"?>"><i class="ri-account-circle-line"></i> Compte</a>
					</li>
					<li>
						<a class="title bold" href="<?="http://" . $_SERVER["SERVER_NAME"] . "/pages/setting.php"?>"><i class="ri-settings-4-line"></i> Options</a>
					</li>
					<li>
						<a class="title bold" href="<?="http://" . $_SERVER["SERVER_NAME"] . "/logic/disconnect.php"?>"><i class="ri-logout-box-line"></i> Deconnexion</a>
					</li>
				</ul>
				</li>
			</ul>
		</nav>
		<?php
		}
		?>

	<style>
		body {
			<?php
			// Check if user is connected
			if (isset($_SESSION["login"])) {
				if (getTheme($_SESSION["login"]) == "0")
					$theme = "light";
				else
					$theme = "dark";
				?>
				background-image: url("<?="http://" . $_SERVER["SERVER_NAME"] . "/public/img/background/" . $theme . "/" . getBackground($_SESSION["login"])?>");
			<?php
			} else { ?>
				background-image: url("<?="http://" . $_SERVER["SERVER_NAME"] . "/public/img/background/light/default.png"?>");
			<?php
			} ?>
		}
	</style>

	<div class="main">
