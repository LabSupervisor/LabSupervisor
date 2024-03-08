<?php
	// Logic
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_nameFormat.php");
?>

<body>
	<nav class="navbar">
		<div class="logo-container left">
			<?php
				// Icon path
				echo "<img src='/public/img/logo.ico'></img>";
			?>
		</div>
			<a class="bold title left no-hover-color">LabSupervisor</a>
				<ul>
					<li>
						<a class="title" href="/"><i class="ri-home-line"></i> Accueil</a>
					</li>
		<?php
			// Check if user is connected
			if (!isset($_SESSION["login"])) { ?>
					<li>
						<a class="title" href="/login"><i class="ri-user-line"></i> Connexion</a>
					</li>
				</ul>
			</nav>
		<?php
			// If the user is connected
			} else {
				$navbarItem = "";
				$roleList = permissionChecker(true, "");

				if (in_array(admin, $roleList) || in_array(teacher, $roleList)) {
					$navbarItem .= '<li><a class="title" href="/classes"><i class="ri-folder-line"></i> Classes</a></li>';
				}

				if (in_array(teacher, $roleList)) {
					$navbarItem .= '<li><a class="title" href="/sessioncreation"><i class="ri-computer-line"></i> Créer une session</a></li>';
				}

				if (in_array(admin, $roleList) || in_array(student, $roleList) || in_array(teacher, $roleList)) {
					$navbarItem .= '<li><a class="title" href="/sessions"><i class="ri-slideshow-3-line"></i> Voir mes sessions</a></li>';
				}

				if (in_array(admin, $roleList)) {
					$navbarItem .= '<li><a class="title" href="/utilisateurs"><i class="ri-folder-line"></i> Utlisateurs</a></li>';
					$navbarItem .= '<li><a class="title" href="/logs?trace"><i class="ri-computer-line"></i> Logs</a></li>';
				}

				echo $navbarItem;

				// Profil part if connected
				$username = nameFormat($_SESSION["login"], true);
		?>
			<li><a class="title case profil" href="#"><i class="ri-user-line"></i> <?=$username?></a>
				<ul class="sub">
					<li>
						<a class="title" href="/compte"><i class="ri-account-circle-line"></i> Compte</a>
					</li>
					<li>
						<a class="title" href="/parametres"><i class="ri-settings-4-line"></i> Options</a>
					</li>
					<li>
						<a class="title" href="/deconnexion"><i class="ri-logout-box-line"></i> Deconnexion</a>
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
			// Check if user is connected to change his theme
			if (isset($_SESSION["login"])) {
				$userSetting = UserRepository::getSetting($_SESSION["login"]);

				if ($userSetting["theme"] == "0")
					$theme = "light";
				else
					$theme = "dark";
				?>
				background-image: url("/public/img/background/<?=$theme?>/default.png");
			<?php
			} else { ?>
				background-image: url("/public/img/background/light/default.png");
			<?php
			} ?>
		}
	</style>

	<div class="main">
