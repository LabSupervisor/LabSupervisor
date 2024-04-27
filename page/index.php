<?php

	use function
		LabSupervisor\functions\mainHeader,
		LabSupervisor\functions\permissionChecker,
		LabSupervisor\functions\lang;

	// Import header
	mainHeader("", true);
?>

<link rel="stylesheet" href="/public/css/index.css">

<?php
	$roleList = permissionChecker(true, "");
	if (in_array(ADMIN, $roleList)) {
?>
		<!-- HTML content specific to admin role -->
		<div class="boxGroup">
			<div class="mainbox">
				<h2><?= lang("NAVBAR_SESSION") ?></h2>
				<a>Sur cette page vous pouvez consulter toutes les sessions en cours créées par les professeurs, en tant qu'administrateurs vous pouvez seulements les consulter</a>
				<button class="button" onclick="window.location.href = '/sessions'"><i class="ri-slideshow-3-line"></i> <?= lang("NAVBAR_SESSION") ?></button>
			</div>

			<div class="mainbox">
				<h2><?= lang("NAVBAR_USER") ?></h2>
				<a>Vous pouvez superviser tous les utilisateurs du site sur cette page; c'est a dire les modifiers a votre guise et les supprimer de la base de données du site web</a>
				<button class="button" onclick="window.location.href = '/utilisateurs'"><i class="ri-folder-line"></i> <?= lang("NAVBAR_USER") ?></button>
			</div>

			<div class="mainbox">
				<h2><?= lang("NAVBAR_LOG") ?></h2>
				<a>Ici vous pouvez consulter l'historique des modifications des autres admins</a>
				<button class="button" onclick="window.location.href = '/logs?trace'"><i class="ri-computer-line"></i> <?= lang("NAVBAR_LOG") ?></button>
			</div>
		</div>
<?php
	} elseif (in_array(STUDENT, $roleList)) {
?>
		<!-- HTML content specific to student role -->
		<div class="boxGroup">
			<div class="mainbox">
				<h2><?= lang("NAVBAR_SESSION") ?></h2>
				<a>D'ici vous pouvez consulter toutes les sessions auquels vous avez été inscrit</a>
				<button class="button" onclick="window.location.href = '/sessions'"><i class="ri-slideshow-3-line"></i> <?= lang("NAVBAR_SESSION") ?></button>
			</div>
		</div>
<?php
	} elseif (in_array(TEACHER, $roleList)) {
?>
		<!-- HTML content specific to teacher role -->
		<div class="boxGroup">
			<div class="mainbox">
				<h2><?= lang("NAVBAR_CLASS") ?></h2>
				<a>Sur cette page vous pouvez consulter les classes auquels vous avez été attitré</a>
				<button class="button" onclick="window.location.href = '/classes'"><i class="ri-folder-line"></i> <?= lang("NAVBAR_CLASS") ?></button>
			</div>
			<div class="mainbox">
				<h2><?= lang("NAVBAR_CREATE_SESSION") ?></h2>
				<a>C'est avec cette page que vous pouvez crée une session ,une fois la session crée vous pourrez la consulté grace au boutons Mes sessions ci-dessous</a>
				<button class="button" onclick="window.location.href = '/sessioncreation'"><i class="ri-computer-line"></i> <?= lang("NAVBAR_CREATE_SESSION") ?></button>
			</div>
			<div class="mainbox">
				<h2><?= lang("NAVBAR_SESSION") ?></h2>
				<a>Ici vous pouvez consulter les sessions auquels vous avez été inscrit ou que vous avez vous meme crée</a>
				<button class="button" onclick="window.location.href = '/sessions'"><i class="ri-slideshow-3-line"></i> <?= lang("NAVBAR_SESSION") ?></button>
			</div>
		</div>
	</div>
<?php
	}

	require($_SERVER["DOCUMENT_ROOT"] . '/include/footer.php');
?>
