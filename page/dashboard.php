<?php
	// Import header
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_header.php");
	mainHeader("Options");

	// Ask for permissions
	permissionChecker(true, array(teacher));
?>

<link rel="stylesheet" href="/public/css/dashboard.css">

<div id="preview-container">

<?php
	$users = SessionRepository::getParticipant($_SESSION["session"]);

	// Display users in the div <preview-container>
	displayUsers($users);

	function displayUsers($users) {
		foreach ($users as $index => $user) {
			$userCell = '<div class="user-cell">';

			// Display of the "camera offline" icon
			$userCell .= '<div class="user-icon"><i class="ri-camera-off-line"></i></div>';
			$userCell .= '<div class="name-and-balls-container">';

			// Adding of the name and the status balls
			$userCell .= '<p>' . $user['name'] . ' ' . $user['surname'] . '</p>';

			$userCell .= '<div class="status-balls-container">';
			$userCell .= createStatusBalls($user['state'], $user['title'], $user['surname'], $user['name']);

			$userCell .= '</div>'; // Closing "name-and-balls-container"
			$userCell .= '</div>'; // Closing "user-icon"

			// Use of the tooltip
			$tooltip = '<div class="tooltip">';
			$tooltip .= '<span class="tooltip-title">Tâches de ' . $user['name'] . ' ' . $user['surname'] . '</span>';
			$tooltip .= '<div class="tooltip-text">';

			// Display for all cells thanks to foreach
			// foreach ($user['title'] as $chapter) {
				$tooltip .= '<div>' . $user["title"];
				$tooltip .= createStatusBalls($user['state'], $user["title"], $user['surname'], $user['name']);
				$tooltip .= '</div>';
			// }

			$tooltip .= '</div>';
			$tooltip .= '</div>';
			$userCell .= $tooltip;
			$userCell .= '</div>'; // Closing "user-cell"

			echo $userCell;
		}

		// Adding a cell to invite new users with a unique ID
		$inviteCell = '<div class="invite-cell" id="invite-cell">';
		$inviteCell .= '<div class="user-icon2"><i class="ri-user-add-line"></i></div>';
		$inviteCell .= '<div class="name-and-balls-container">';
		$inviteCell .= "<p>Inviter d'autres utilisateurs</p>";

		$inviteCell .= '</div>';
		$inviteCell .= '</div>';

		echo $inviteCell;
	}

	function createStatusBalls($state, $chapter, $surname, $name) {
		$statusBallsContainer = '<div class="status-balls-container">';

		// Start of tooltip
		$tooltip = '<div class="tooltip">';
		$tooltip .= '<span class="tooltip-title">Tâches de ' . $surname . ' ' . $name . '</span>';
		$tooltip .= '<div class="tooltip-text">';

		// Add each task with status balls
		// foreach ($chapters as $chapter) {
			// Task and status balls container
			$tooltip .= '<div class="task-container">';
			$tooltip .= $chapter;

			// Status balls container with a CSS class
			$tooltip .= '<div class="status-balls-container-right">';
			$tooltip .= '<div class="status-ball status-Finished active"></div>';
			$tooltip .= '<div class="status-ball status-Working"></div>';
			$tooltip .= '<div class="status-ball status-In-trouble"></div>';
			$tooltip .= '</div>';

			$tooltip .= '</div>';
		// }

		$tooltip .= '</div>';
		// End of the tooltip
		$tooltip .= '</div>';
		$statusBallsContainer .= $tooltip;

		// Adding status balls outside the tooltip
		$finishedBall = createStatusBall('status-Finished', $state === '3');
		$workingBall = createStatusBall('status-Working', $state === '2');
		$troubleBall = createStatusBall('status-In-trouble', $state === '1');
		$statusBallsContainer .= $finishedBall . $workingBall . $troubleBall;
		$statusBallsContainer .= '</div>';

		return $statusBallsContainer;
	}

	// The main class "$statusClass" is determined by the state type, and an additional class "$activeClass" is added if the ball is active
	// This serves to decide whether the ball lights up or not in bulk
	function createStatusBall($statusClass, $isActive) {
		$activeClass = $isActive ? ' active' : '';
		$statusBall = '<div class="status-ball ' . $statusClass . $activeClass . '"></div>';
		return $statusBall;
	}
?>

</div>

<script>
	// Change cell color between 5 definite colors
	document.addEventListener('DOMContentLoaded', function() {
		// Definite colours
		const couloursCells = ["#f57e7e", "#f384ae", "#b778ff", "#ecff78", "#fbbc62"];

		// Obtaining all elements with the class ". user-icon"
		const userIcons = document.querySelectorAll(".user-icon");

		// Iteration between the different colors available and aleatory cell selection
		userIcons.forEach(function(userIcon) {
			const randomColour = obtenerColorAleatorio();

			// Apply color
			userIcon.style.backgroundColor = randomColour;
		});

		// Function to avoid color repetition between cells
		function obtenerColorAleatorio() {
			// Get aleatory color from those that are available
			const randomColour = couloursCells[Math.floor(Math.random() * couloursCells.length)];
			return randomColour;
		}
	});

	// Code to display the tooltip in the opposite direction if it exceeds the page
	document.addEventListener('DOMContentLoaded', function () {
		// Function to modify the tooltips
		function adjustTooltips() {
			// Get all the elements with the 'tooltip' clase
			const tooltips = document.querySelectorAll(".tooltip");

			// Iterate on each tooltip and modify it if necessary
			tooltips.forEach(function (tooltip) {
				// Obtaining the position of the tooltip
				const tooltipRect = tooltip.getBoundingClientRect();
				const windowWidth = window.innerWidth;

				// Check if the tooltip exceeds the edge of the page
				if (tooltipRect.right > windowWidth) {
					// Change the position of the tooltip (to reverse it)
					const offset = 30;
					tooltip.style.left = 'auto';
					tooltip.style.right = offset + 'px';
				}
			});
		}

		// Call the function when a change to the page size occur
		adjustTooltips();
		window.addEventListener('resize', adjustTooltips);
	});
</script>
