<?php
function roleFormat($student, $teacher, $admin) {
	$result = "";
	if ($student == True)
		$result = $result . "Etudiant";
	if ($teacher == True)
		$result = $result . "Enseignant";
	if ($admin == True)
		$result = $result . "Admin";

	return $result;
}
