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
						<a class="title bold" href="#"><i class="ri-computer-line"></i> Voir mes sessions</a>
					</li>
		<?php }
			// If the user is a student
			else if(in_array("student", $roleList)) { ?>
				<li>
					<a class="title bold" href="#"><i class="ri-computer-line"></i> Voir mes sessions</a>
				</li>
		<?php }
			// If the user is an admin
			else if (in_array("admin", $roleList)) { ?>
				<li>
					<a class="title bold" href="#"><i class="ri-folder-line"></i> Classes</a>
				</li>
				<li>
					<a class="title bold" href="#"><i class="ri-computer-line"></i> Sessions</a>
				</li>
				<li>
					<a class="title bold" href="#"><i class="ri-computer-line"></i> Logs</a>
				</li>
		<?php
			}
			// Profil part if connected
		?>
			<li><a class="title bold" href="#"><i class="ri-user-line"></i> Profil</a>
				<ul class="sub">
					<li>
						<a href="<?="http://" . $_SERVER["SERVER_NAME"] . "/logic/disconnect.php"?>"> Deconnexion</a>
					</li>
				</ul>
				</li>
			</ul>
		</nav>
		<?php
		}
		?>
