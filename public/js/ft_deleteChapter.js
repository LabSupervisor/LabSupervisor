function deleteChapter(button) {
	let nbChapter = document.querySelectorAll('.chapter-container').length;

	if (nbChapter > 1) {
		let chapterContainer = button.parentNode;

		// Récupérer l'ID du chapitre à supprimer en utilisant la classe 'chapter-id'
		let deletedChapterIdInput = chapterContainer.querySelector('.chapter-id');
		console.log('deletedChapterIdInput : ' + deletedChapterIdInput);

		// Si la balise n'existe pas, il faut simplement supprimer le container HTML
		// if(deletedChapterIdInput == null){
		// }
		// Sinon, on continue le traitement de la suppression
		if (deletedChapterIdInput !=null) {
			deletedChapterId = deletedChapterIdInput.value;
			console.log('deletedChapterId : ' + deletedChapterId);

			// Créer un champ caché dans un autre formulaire pour stocker l'ID du chapitre supprimé
			let deletedChaptersInput = document.createElement('input');
			deletedChaptersInput.setAttribute('type', 'hidden');
			deletedChaptersInput.setAttribute('name', 'deletedChapters[]');
			deletedChaptersInput.setAttribute('value', deletedChapterId);
			document.querySelector('#formSession').appendChild(deletedChaptersInput);
		}

		chapterContainer.remove();

	} else {
		alert("Vous ne pouvez pas supprimer tous les chapitres.");
	}
}
