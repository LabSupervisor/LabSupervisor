<?php
require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_header.php");
mainHeader("Lab Administration")
?>




<form class="" action="" method="post">
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
// Connexion à la BDD
require($_SERVER["DOCUMENT_ROOT"] . '/config/config.php');
?>

<?php


if (isset($_POST['Enregistrer'])) {
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
		// Récupérer la colonne 'id' en tant que chaîne de caractères
		$userId = $queryIdUserPrep->fetchColumn();

		if ($userId !== false) {
			echo "Session enregistrée avec succès. L'ID de l'utilisateur est : " . $userId;
		} else {
			echo "Aucun résultat trouvé.";
		}
	}



	$query = "INSERT INTO session (title, description, idcreator, creationdate, enddate) VALUES (:title, :description, :idcreator, :startdate, :enddate)";
	// $queryBis = "INSERT INTO chapter (idsession, title, description, idcreator) VALUES (:idsession, :title, :description, :idcreator)";

	$queryPrep = $db->prepare($query);
	// $queryPrepBis = $db->prepare($queryBis);


	// Remplacement des paramètres avec les valeurs du formulaire
	$queryPrep->bindParam(':title', $titleSession, \PDO::PARAM_STR);
	$queryPrep->bindParam(':description', $descriptionSession, \PDO::PARAM_STR);
	$queryPrep->bindParam(':idcreator', $userId, \PDO::PARAM_INT);
	$queryPrep->bindParam(':creationdate', $startDate, \PDO::PARAM_STR);
	$queryPrep->bindParam(':enddate', $dateEnd, \PDO::PARAM_STR);

	// Exécution de la requête
	if ($queryPrep->execute()) {
		echo "Session enregistrée avec succès.";
	} else {
		echo "Erreur lors de l'enregistrement de la session : ";
	}
}
?>
