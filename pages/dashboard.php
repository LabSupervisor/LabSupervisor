<?php
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_header.php");
	mainHeader("Dashboard");
?>

<link rel="stylesheet" href="<?="http://" . $_SERVER["SERVER_NAME"] . "/public/css/dashboard.css"?>">

<div id="preview-container">

<?php
	// Utilisateurs prédéfinis (A remplacer)
	$users = [
		['Nom_Utilisateur' => 'Alice', 'Prenom_Utilisateur' => 'Wonderland', 'etat' => 'Finalisé', 'taches' => ['PHP pour les nuls', 'PHP mais en mieux','Mysql sur JS ? Omg...']],
		['Nom_Utilisateur' => 'Bob', 'Prenom_Utilisateur' => 'Builder', 'etat' => 'En Difficulté', 'taches' => ['Tache 3', 'Tache 4']],
		['Nom_Utilisateur' => 'Charlie', 'Prenom_Utilisateur' => 'Chocolate', 'etat' => 'En Cours', 'taches' => ['Tache 5', 'Tache 6']],
		['Nom_Utilisateur' => 'David', 'Prenom_Utilisateur' => 'Dynamite', 'etat' => 'En Difficulté', 'taches' => ['Tache 7', 'Tache 8']],
		['Nom_Utilisateur' => 'Romain', 'Prenom_Utilisateur' => 'Plantfinito (Abdel)', 'etat' => 'Finalisé', 'taches' => ['Tache 9', 'Tache 10']],
		['Nom_Utilisateur' => 'Frank', 'Prenom_Utilisateur' => 'Fantastic', 'etat' => 'En Cours', 'taches' => ['Tache 11', 'Tache 12']],
		['Nom_Utilisateur' => 'Alberto', 'Prenom_Utilisateur' => 'Gonzales', 'etat' => 'Finalisé', 'taches' => ['Tache 13', 'Tache 14']],
		['Nom_Utilisateur' => 'Oliver', 'Prenom_Utilisateur' => 'Benji', 'etat' => 'En Difficulté', 'taches' => ['Tache 15', 'Tache 16']],
		['Nom_Utilisateur' => 'Jean', 'Prenom_Utilisateur' => 'Pol', 'etat' => 'En Cours', 'taches' => ['Tache 17', 'Tache 18']],
	];

	// Afficher les utilisateurs
	displayUsers($users);

	function displayUsers($users) {
		foreach ($users as $index => $user) {
			$userCell = '<div class="user-cell">';

			// Cambio de la imagen a un icono
			$userCell .= '<div class="user-icon"><i class="ri-camera-off-line"></i></div>';
			$userCell .= '<div class="name-and-balls-container">';
			// Ajout du nom et des balles d'état
			$userCell .= '<p>' . $user['Nom_Utilisateur'] . ' ' . $user['Prenom_Utilisateur'] . '</p>';

			$userCell .= '<div class="status-balls-container">';
			$userCell .= createStatusBalls($user['etat'], $user['taches'], $user['Nom_Utilisateur'], $user['Prenom_Utilisateur']);
			$userCell .= '</div>'; // Fermeture de status-balls-container

			$userCell .= '</div>'; // Fermeture de name-and-balls-container

			// Utilisation du tooltip
			$tooltip = '<div class="tooltip">';
			$tooltip .= '<span class="tooltip-title">Tâches de ' . $user['Nom_Utilisateur'] . ' ' . $user['Prenom_Utilisateur'] . '</span>';
			$tooltip .= '<div class="tooltip-text">';

			foreach ($user['taches'] as $tache) {
				$tooltip .= '<div>' . $tache;
				$tooltip .= createStatusBalls($user['etat'], [$tache], $user['Nom_Utilisateur'], $user['Prenom_Utilisateur']);
				$tooltip .= '</div>';
			}

			$tooltip .= '</div>';
			$tooltip .= '</div>';
			$userCell .= $tooltip;

			$userCell .= '</div>'; // Fermeture de user-cell

			echo $userCell;
		}

		// Ajout d'une cellule pour inviter de nouveaux utilisateurs
		$inviteCell = '<div class="user-cell">';
		$inviteCell .= '<img src="../public/img/Invit.png" alt="Inviter de nouveaux utilisateurs">';
		$inviteCell .= '<div class="name-and-balls-container">';
		$inviteCell .= '<p>Inviter nouveaux utilisateurs</p>';
		$inviteCell .= '</div>'; // Fermeture de name-and-balls-container
		$inviteCell .= '</div>'; // Fermeture de user-cell

		echo $inviteCell;
	}

	function createStatusBalls($etat, $taches, $nomUtilisateur, $prenomUtilisateur) {
		$statusBallsContainer = '<div class="status-balls-container">';

		// Début du tooltip
		$tooltip = '<div class="tooltip">';
		$tooltip .= '<span class="tooltip-title">Tâches de ' . $nomUtilisateur . ' ' . $prenomUtilisateur . '</span>';
		$tooltip .= '<div class="tooltip-text">';

		// Ajouter chaque tâche avec les status balls
		foreach ($taches as $tache) {
			// Conteneur de la tâche et des status balls
			$tooltip .= '<div class="task-container">';
			$tooltip .= $tache;

			// Conteneur des status balls avec une classe CSS
			$tooltip .= '<div class="status-balls-container-right">';
			$tooltip .= '<div class="status-ball status-Finished active"></div>';
			$tooltip .= '<div class="status-ball status-Working"></div>';
			$tooltip .= '<div class="status-ball status-In-trouble"></div>';
			$tooltip .= '</div>';

			$tooltip .= '</div>';
		}

		$tooltip .= '</div>';
		// Fin du tooltip
		$tooltip .= '</div>';
		$statusBallsContainer .= $tooltip;

		// Ajout des status balls en dehors du tooltip
		$finishedBall = createStatusBall('status-Finished', $etat === 'Finalisé');
		$workingBall = createStatusBall('status-Working', $etat === 'En Cours');
		$troubleBall = createStatusBall('status-In-trouble', $etat === 'En Difficulté');
		$statusBallsContainer .= $finishedBall . $workingBall . $troubleBall;
		$statusBallsContainer .= '</div>';

		return $statusBallsContainer;
	}


	function createStatusBall($statusClass, $isActive) {
		$activeClass = $isActive ? ' active' : '';
		$statusBall = '<div class="status-ball ' . $statusClass . $activeClass . '"></div>';
		return $statusBall;
	}
	?>

</div>
