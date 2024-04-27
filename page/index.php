<?php

	use function
		LabSupervisor\functions\mainHeader,
		LabSupervisor\functions\permissionChecker;

	// Import header
	mainHeader("", true);
?>

<?php
	$roleList = permissionChecker(true, "");
	if (in_array(ADMIN, $roleList)) {
?>
		<!-- HTML content specific to Admin role -->
		<link rel="stylesheet" href="/public/css/log.css">
		<div class="mainbox table-container">
			<div class="mainbox-index">
				<p class="pindex">Sur cette page vous pouvez consulter toutes les sessions en cours créées par les professeurs, en tant qu'administrateurs vous pouvez seulements les consulter</p>
				<a class="button-index" href='/sessions'>Mes Sessions</a>
			</div>

			<div class="mainbox-index">
				<p class="pindex">Vous pouvez superviser tous les utilisateurs du site sur cette page; c'est a dire les modifiers a votre guise et les supprimer de la base de données du site web</p>
				<a class="button-index" href='/utilisateurs'>Utilisateurs</a>
			</div>

			<div class="mainbox-index">
				<p class="pindex">Ici vous pouvez consulter l'historique des modifications des autres admins</p>
				<a class="button-index" href='/logs?trace'>Logs</a>
			</div>
		</div>
<?php
	} elseif (in_array(STUDENT, $roleList)) {
?>
		<!-- HTML content specific to Etudiant role -->
		<div class="mainbox table-container">
			<div class="mainbox-index">
			<p class="pindex">D'ici vous pouvez consulter toutes les sessions auquels vous avez été inscrit </p>
			<a class="button-index" href='/session'>Mes Sessions</a>
			</div>
		</div>
<?php
	} elseif (in_array(TEACHER, $roleList)) {
?>
		<!-- HTML content specific to Enseignant role -->
		<div class="mainbox table-container">
			<div class="mainbox-index">
				<p class="pindex">Sur cette page vous pouvez consulter les classes auquels vous avez été attitré</p>
				<a class="button" href='/classes'>Mes Classes</a>
			</div>
			<div class="mainbox-index">
				<p class="pindex">C'est avec cette page que vous pouvez crée une session ,une fois la session crée vous pourrez la consulté grace au boutons Mes sessions ci-dessous</p>
				<a class="button-index" href='/sessioncreation'>Crée une session</a>
			</div>
			<div class="mainbox-index">
				<p class="pindex">Ici vous pouvez consulter les sessions auquels vous avez été inscrit ou que vous avez vous meme crée</p>
				<a class="button-index" href='/sessions'>Mes Sessions</a>
			</div>
		</div>
	</div>
<?php
	}

	require($_SERVER["DOCUMENT_ROOT"] . '/include/footer.php');
?>
