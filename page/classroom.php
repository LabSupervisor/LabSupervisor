<?php
	use
		LabSupervisor\app\repository\ClassroomRepository,
		LabSupervisor\app\repository\UserRepository;
	use function
		LabSupervisor\functions\mainHeader,
		LabSupervisor\functions\lang,
		LabSupervisor\functions\permissionChecker;

	mainHeader(lang("NAVBAR_CLASS"), true);

	permissionChecker(true, array(TEACHER));

	// Logic
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/updateClassroom.php");


?>
<link rel="stylesheet" href="/public/css/classroom.css">

<script>

	// Menu latéral : affiche le contenu d'une classe
	function selectClass(id)
	{
		try
		{
			// Nom de la classe dans le menu latéral
			document.querySelector('.classname[selected]').removeAttribute('selected');
			document.getElementById('class-'+id).setAttribute('selected','');

			// Contenu de la classe
			document.querySelector('.content-class[selected]').removeAttribute('selected');
			document.getElementById('content-class-'+id).setAttribute('selected','');
		}
		catch(e)
		{
			console.error(e.stack);
		}
	}

</script>

<?php
	// Affichage de la page

	$classrooms = ClassroomRepository::getClassrooms();


	// Menu latéral de selection des classes
	echo '<div id="lateral-selector" class="mainbox">';

	for($i = 0; $i < count($classrooms); $i++) 
	{
		$classroom = $classrooms[$i];

		$selected = "";
		if($i == 0) // Auto-selection de la première classe
			$selected = "selected";

		if ($classroom["active"] == "1")
		{
			echo '<div id="class-' . $classroom["id"] . '" class="classname" ' . $selected . ' onclick="selectClass(' . $classroom["id"] . ')">' . $classroom["name"] . '</div>';
		}
		
	}	
	echo '</div>';


	// Contenu des classes, chaque classe est affichée selon sa sélection sur le menu latéral
	for($i = 0; $i < count($classrooms); $i++) 
	{
		$classroom = $classrooms[$i];

		if ($classroom["active"] == "1")
		{
			$selected = "";
			if($i == 0) // Auto-selection de la première classe
				$selected = "selected";

			?>
			<div id="content-class-<?php echo $classroom["id"]?>" class="mainbox content-class" <?php echo $selected?>>
				<h2><?php echo $classroom["name"]?></h2>
				<table>
					<thead>
						<tr>
							<th>Nom</th>
							<th>Prénom</th>
							<th>Email</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
			<?php

			// Affichage des étudiants de la classe dans le tableau
			$students = ClassroomRepository::getUsers($classroom["name"]);
			foreach ($students as $student) 
			{
				if (UserRepository::isActive(UserRepository::getEmail($student["iduser"]))) 
				{
					$studInfos = UserRepository::getInfo(UserRepository::getEmail($student["iduser"]));

					if (isset($studInfos)) 
					{
						?>
						<tr>
							<td><?= $studInfos["surname"] ?></td>
							<td><?= $studInfos["name"] ?></td>
							<td><?= $studInfos["email"] ?></td>
							<td>
								<!-- Formulaire pour supprimer un étudiant de la classe -->
								<form action="" method="post">
									<input type="hidden" name="class_id" value="<?= $classroom["id"] ?>">
									<input type="hidden" name="remove_student" value="<?= $student["iduser"] ?>">
									<input type="submit" class="button" value="Retirer">
								</form>
							</td>
						</tr>
						<?php
					}
				}
			}
			?>
					</tbody>
				</table>
			<?php

			// Selecteur d'ajout des étudiants "libres" (n'ayant pas de classes)
			$freeStudents = ClassroomRepository::getUsersNotInClassroom();
			if ($freeStudents) 
			{
				echo "<form class='free-students' method='POST'>";
				echo "<input type='hidden' name='class_id' value=" . $classroom["id"] .">";
				echo "<select class='select-student' name='student_id' id='student_id'><label for='student_id'>Sélectionner un élève :</label>";
				foreach ($freeStudents as $student) 
				{
					echo "<option value='" . $student['id'] . "'>" . $student['name'] . " " . $student['surname'] . "</option>";
				}
				echo "</select><input type='submit' class='button' name='add_student' value='Ajouter'></form>";
			}
			?>
			</div>
			<?php
		}
	}
	

	// Footer
	require($_SERVER["DOCUMENT_ROOT"] . '/include/footer.php');

?>
