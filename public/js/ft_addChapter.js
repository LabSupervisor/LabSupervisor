function addHTMLChapter(title, description, button){
	let newIdChapter = parseInt(button.getAttribute("data-id"));
	// mettre à jour le bouton pour incrémenter l'id si jamais il est de nouveau cliqué
	button.setAttribute("data-id", newIdChapter + 1);
	let nbChapter = document.getElementById('nbChapter').value;
	nbChapter++;

	let div = document.createElement('div');
	div.classList.add('chapter-container');

	let inputTitle = document.createElement('input');
	inputTitle.setAttribute("type", "text");
	inputTitle.setAttribute("placeholder", title);
	inputTitle.setAttribute("name", "addChapters[" + newIdChapter +"][title]");
	inputTitle.classList.add('field');
	div.appendChild(inputTitle);

	let inputDescription = document.createElement('textarea');
	inputDescription.setAttribute("name", "addChapters[" + newIdChapter +"][desc]");
	inputDescription.setAttribute("placeholder", description);
	inputDescription.classList.add('field');
	div.appendChild(inputDescription);

	// Delete button
	let deleteButton = document.createElement('button');
	deleteButton.setAttribute("type", "button");
	deleteButton.classList.add('button', 'chapterButton');
	deleteButton.textContent = '- Chapitre';
	deleteButton.addEventListener('click', function() {
		deleteChapter(this);
	});
	div.appendChild(deleteButton);

	// Insert the new chapter zone after the last existing chapter
	let lastChapterContainer = document.querySelector('.chapter-container:last-of-type');
	lastChapterContainer.parentNode.insertBefore(div, lastChapterContainer.nextSibling);
}
