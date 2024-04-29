function addHTMLChapter(title, description, button) {
	let newIdChapter = parseInt(button.getAttribute("dataid"));
	// update the button to increment the id if it is clicked again
	button.setAttribute("dataid", newIdChapter +1);
	let nbChapter = document.getElementById('nbChapter').value;
	nbChapter++;

	let div = document.createElement('div');
	div.classList.add('subform');

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
	deleteButton.textContent = lang("SESSION_CREATE_CHAPTER_REMOVE");
	deleteButton.addEventListener('click', function() {
		deleteChapter(this);
	});
	div.appendChild(deleteButton);

	// Insert the new chapter zone after the last existing chapter
	let lastsubform = document.querySelector('.subform');
	lastsubform.parentNode.insertBefore(div, lastsubform.nextSibling);
}
