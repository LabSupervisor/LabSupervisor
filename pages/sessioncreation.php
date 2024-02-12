<link rel="stylesheet" href="../public/css/sessioncreation.css">
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

<form class="sessions" method="post">
	<input type="hidden" value="1" name="nbChapter" id="nbChapter">
	<fieldset>
		<legend> Information </legend>
		<strong class="strong1"> Titre : </strong>
		<input type="text" id="titleSession" class="firstbox" name="titleSession" required>
		<strong class="strong2"> Description : </strong>
		<textarea id="descriptionSession" class="secondbox" name="descriptionSession"></textarea>
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

		<div class="custom-select">
			<span class="ri ri-arrow-down-wide-line"></span>
			<select name="classes" id="classes">
				<?php
				for ($i = 0; $i < count($tabClass); $i++) {
					?>
					<option value="<?php echo $tabClass[$i]["id"]; ?>"><?php echo $tabClass[$i]["name"]; ?></option>
					<?php
				}
				?>
			</select>
		</div>

	</fieldset>
	<fieldset>
   		<legend>Chapitres</legend>
  			<strong class="strong1">Titre :</strong>
  			<input type="text" id="titleChapter1" class="firstbox" name="titleChapter1">
   			<strong class="strong2">Description :</strong>
   			<textarea id="chapterDescription1" class="secondbox" name="chapterDescription1"></textarea>
   			<div class="buttonC">
       		<button id="btn-chapter" class="button" onclick="addChapter()">+ Chapitre</button>
    		</div>
		</fieldset>
	<fieldset>
		<legend> Date </legend>
		<strong> Date : </strong>
		<input type="datetime-local" id="date" name="date"  required>
	</fieldset>
	<input type="submit" name="saveSession" class="button2" value="Enregistrer">
</form>
