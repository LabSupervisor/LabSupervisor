<?php
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_header.php");
	mainHeader("Lab Administration")
?>

<?php
	// TODO TEMP
	// DB connection
	require($_SERVER["DOCUMENT_ROOT"] . '/config/config.php');
	require($_SERVER["DOCUMENT_ROOT"] . '/src/App/Repositories/log.php');
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
		<!-- TODO Request get class -->
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
		<input type="datetime-local" id="startDate" name="startDate" required>
		<strong> Date de fin : </strong>
		<input type="datetime-local" id="endDate" name="endDate" required>
	</fieldset>
	<input type="submit" name="saveSession" value="Enregistrer">
</form>
