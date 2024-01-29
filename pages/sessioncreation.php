<?php
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_header.php");
	mainHeader("Lab Administration")
?>

<?php
	// Logic
	require($_SERVER["DOCUMENT_ROOT"] . '/logic/createSession.php');
?>

<form method="post">
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

		<?php
		$db = dbConnect();

		$queryClass = "SELECT id, name FROM classroom";
		$queryClassPrep = $db->prepare($queryClass);
		if ($queryClassPrep->execute()) {
			$tabClass = $queryClassPrep->fetchAll();
		}

		// var_dump($tabClass)
		?>

		<select name="classes" id="classes">
			<?php
				for ($i = 0; $i< count($tabClass); $i++){
				?>
			        <option value="<?php echo $tabClass[$i]["id"]; ?>"><?php echo $tabClass[$i]["name"]; ?></option>
				<?php
				}

			?>
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
		<input type="datetime-local" id="startDate" name="startDate" required>
		<strong> Date de fin : </strong>
		<input type="datetime-local" id="endDate" name="endDate" required>
	</fieldset>
	<input type="submit" name="saveSession" value="Enregistrer">
</form>
