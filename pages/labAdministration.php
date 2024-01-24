<?php
require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_header.php");
mainHeader("Lab Administration")
?>

<?php
//BDD connection
require($_SERVER["DOCUMENT_ROOT"] . '/config/config.php');
?>

<form class="" action="labAdministration.php" method="post">
	<fieldset>
		<legend> Information </legend>
		<strong> Titre : </strong>
		<input type="text" id="titleSession" name="titleSession" required>
		<strong> Description : </strong>
		<input type="text" id="descriptionSession" name="descriptionSession" required>
	</fieldset>
	<fieldset>
		<legend> Participants </legend>
		<strong> Classes : </strong>
		<select name="classes" id="classes">
			<option value="classe1">Classe 1</option>
			<option value="classe2">Classe 2</option>
			<option value="classe3">Classe 3</option>
		</select>
	</fieldset>
	<fieldset>
		<legend> Chapitres </legend>
		<strong> Titre : </strong>
		<input type="text" id="titleChapter" name="titleChapter" required>
		<strong> Description : </strong>
		<input type="text" id="chapterDescription" name="chapterDescription" required>
	</fieldset>
	<fieldset>
		<legend> Dates </legend>
		<strong> Date de début : </strong>
		<input type="date" id="startDate" name="startDate" required>
		<strong> Date de fin : </strong>
		<input type="date" id="dateEnd" name="dateEnd" required>
	</fieldset>
	<input type="submit" value="Enregistrer">
</form>

<?php

if (!isset($_POST['Enregistrer'])) {
	$db = dbConnect();

	$titleSession = $_POST['titleSession'];
	$descriptionSession = $_POST['descriptionSession'];
	$classes = $_POST['classes'];
	$titleChapter = $_POST['titleChapter'];
	$chapterDescription = $_POST['chapterDescription'];
	$startDate = $_POST['startDate'];
	$dateEnd = $_POST['dateEnd'];

	$queryIdUser = "SELECT id FROM user WHERE email = 'admin@labsupervisor.com' ";
	$queryIdUserPrep = $db->prepare($queryIdUser) ;
	if ($queryIdUserPrep->execute()) {
		$userId = $queryIdUserPrep->fetchColumn();
	}

	$query = "INSERT INTO session (title, description, idcreator, startdate, enddate) VALUES (:title, :description, :idcreator, :startdate, :enddate)";

	$queryPrep = $db->prepare($query);

	// bind parameter
	$queryPrep->bindParam(':title', $titleSession, \PDO::PARAM_STR);
	$queryPrep->bindParam(':description', $descriptionSession, \PDO::PARAM_STR);
	$queryPrep->bindParam(':idcreator', $userId, \PDO::PARAM_INT);
	$queryPrep->bindParam(':startdate', $startDate, \PDO::PARAM_STR);
	$queryPrep->bindParam(':enddate', $dateEnd, \PDO::PARAM_STR);

	if ($queryPrep->execute()) {
		echo "Session enregistrée avec succès.";
	} else {
		echo "Erreur lors de l'enregistrement de la session : ";
	}

	// recup id session
	$queryIdSession = "SELECT id FROM session WHERE title = '$titleSession'" ;
	$queryIdSessionPrep = $db->prepare($queryIdSession);

	if ($queryIdSessionPrep->execute()) {
		$idSession = $queryIdSessionPrep->fetchColumn();
	}

	// chapter
	$queryBis = "INSERT INTO chapter (idsession, title, description, idcreator) VALUES (:idsession, :title, :description, :idcreator)";

	$queryPrepBis = $db->prepare($queryBis);

	// bind parameter
	$queryPrepBis->bindParam(':idsession', $idSession, \PDO::PARAM_STR);
	$queryPrepBis->bindParam(':title', $titleChapter, \PDO::PARAM_STR);
	$queryPrepBis->bindParam(':description', $chapterDescription, \PDO::PARAM_STR);
	$queryPrepBis->bindParam(':idcreator', $userId, \PDO::PARAM_INT);

	// requete execute

	if ($queryPrepBis->execute()) {
		echo "Session (chapitre) enregistrée avec succès.";
	} else {
		echo "Erreur lors de l'enregistrement de la session : ";
	}

}
?>
