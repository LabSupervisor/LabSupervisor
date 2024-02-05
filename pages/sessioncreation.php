<?php
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_header.php");
	mainHeader("Création de session")
?>

<?php
	// Logic
	require($_SERVER["DOCUMENT_ROOT"] . '/logic/createSession.php');
?>

<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
?>

<script>
	var nbChapter = 1;

	// Update chapter count
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
	<input type="hidden" value="1" name="nbChapter" id="nbChapter">
	<fieldset>
		<legend> Information </legend>
		<strong> Titre : </strong>
		<input type="text" id="titleSession" name="titleSession" required>
		<strong> Description : </strong>
		<input type="text" id="descriptionSession" name="descriptionSession">
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
			<input type="text" id="chapterDescription1" name="chapterDescription1">
		</div>
		<button id="btn-chapter" onclick="addChapter()">+ Chapitre</button>
	</fieldset>

	<fieldset>
		<legend> Date </legend>
		<strong> Date : </strong>
		<input type="datetime-local" id="date" name="date" required>
	</fieldset>
	<input type="submit" name="saveSession" value="Enregistrer">
</form>
