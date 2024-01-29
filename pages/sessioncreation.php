<?php
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_header.php");
	mainHeader("Lab Administration")
?>

<?php
	// Logic
	require($_SERVER["DOCUMENT_ROOT"] . '/logic/createSession.php');
?>

<script>
	var nbChapter = 3;

	//met à jour le nombre de chapitres
	function addChapter()
	{
		nbChapter++ ;
		let div= document.createElement('div');

		let title = document.createElement('strong');
		title.innerHTML="Titre : " ;
		div.appendChild(title);

		let inputTitle = document.createElement('input') ;
		inputTitle.setAttribute("type", "texte")
		inputTitle.setAttribute("id", "titleChapter"+nbChapter)
		inputTitle.setAttribute("name", "titleChapter"+nbChapter);
		div.appendChild(inputTitle)

		let description = document.createElement('strong')
		description.innerHTML=' Description : '
		div.appendChild(description)

		let inputDescription = document.createElement('input') ;
		inputDescription.setAttribute("type", "texte")
		inputDescription.setAttribute("id", "chapterDescription"+nbChapter)
		inputDescription.setAttribute("name", "chapterDescription"+nbChapter);
		div.appendChild(inputDescription)


		let btnChapter = document.getElementById('btn-chapter');
		let fieldChapters = document.getElementById('fieldChapters');
		fieldChapters.insertBefore(div, btnChapter);

		document.getElementById('nbChapter').value= nbChapter;
	}
</script>

<form method="post">
	<input type="hidden" value="3" name="nbChapter" id="nbChapter">
	<fieldset>
		<legend> Information </legend>
		<strong> Titre : </strong>
		<input type="text" id="titleSession" name="titleSession" required>
		<strong> Description : </strong>
		<input type="text" id="descriptionSession" name="descriptionSession" >
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
	<fieldset id="fieldChapters">
		<legend> Chapitres </legend>

		<div>
			<strong> Titre : </strong>
			<input type="text" id="titleChapter1" name="titleChapter1" >
			<strong> Description : </strong>
			<input type="text" id="chapterDescription1" name="chapterDescription1" >
		</div>
		<div>
			<strong> Titre : </strong>
			<input type="text" id="titleChapter2" name="titleChapter2" >
			<strong> Description : </strong>
			<input type="text" id="chapterDescription2" name="chapterDescription2" >
		</div>
		<div>
			<strong> Titre : </strong>
			<input type="text" id="titleChapter3" name="titleChapter3" >
			<strong> Description : </strong>
			<input type="text" id="chapterDescription3" name="chapterDescription3">
		</div>
		<button id="btn-chapter" onclick="addChapter()">+ Chapitre</button>
	</fieldset>

	<fieldset>
		<legend> Dates </legend>
		<strong> Date de début : </strong>
		<input type="datetime-local" id="startDate" name="startDate" required>
		<strong> Date de fin : </strong>
		<input type="datetime-local" id="endDate" name="endDate" >
	</fieldset>
	<input type="submit" name="saveSession" value="Enregistrer">
</form>
