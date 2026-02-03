function createHiddenInputChapter(updatedChapterId, updatedField, updatedValue) {
	let updatedChaptersInput = document.createElement('input');
	updatedChaptersInput.setAttribute('type', 'hidden');
	updatedChaptersInput.setAttribute('id', `_${updatedField}_${updatedChapterId}`);
	updatedChaptersInput.setAttribute('name', `updatedChapters[${updatedChapterId}][${updatedField}]`);
	updatedChaptersInput.setAttribute('value', updatedValue);
	return updatedChaptersInput;
}

function processingField(fieldToBeChanged, valueToBeUpdated, updatedChapterId, targetedForm) {
	// get the 'field has changed' input
	let updatedChaptersInput = document.querySelector(`#_${fieldToBeChanged}_${updatedChapterId}`);
	// if the field of the chapter hasn't been changed yet
	if (updatedChaptersInput == null) {
		// add a new hidden input to the specific form
		document.querySelector(`#${targetedForm}`).appendChild(createHiddenInputChapter(updatedChapterId, fieldToBeChanged, valueToBeUpdated));
	} else {
		// otherwise, just update with the new value
		updatedChaptersInput.setAttribute('value', valueToBeUpdated);
	}
}

/**
 * Function automatically called on change detected on any text input of a chapter.
 * It consists of adding an hidden input to a specific form in order to shubmit the changes
 * on a specific chapter
 * @param {number} updatedChapterId - Id of the chapter to be updated
 * @example
 * updateChapter(6); // Will create an hidden input modifying the chapters' array
 * // regarding chapter 6
 */
function updateChapter(updatedChapterId) {
	// the specific form in which will be added some hidden inputs
	let targetedForm = 'formSession';
	// changing variables
	let fieldToBeChanged;
	let valueToBeUpdated;
	// - get textfield values from the elements of the form -
	// get the title value of the chapter 
	let updatedChapterTitle = document.querySelector(`#titleChapter${updatedChapterId}`).value;
	// get the desc value of the chapter
	let updatedChapterDesc = document.querySelector(`#chapterDescription${updatedChapterId}`).value;

	// searching in the document for an element with an id (#) composed like this :
	// id="_<id of updated chapter>"
	// if it doesn't exist, it is created and then added as an hidden input to the
	// form with id is formSession
	
	// --- Processing id changes ---
	fieldToBeChanged = 'id';
	valueToBeUpdated = updatedChapterId;
	processingField(fieldToBeChanged, valueToBeUpdated, updatedChapterId, targetedForm);
	
	// --- Processing title changes ---
	fieldToBeChanged = 'title';
	valueToBeUpdated = updatedChapterTitle;
	processingField(fieldToBeChanged, valueToBeUpdated, updatedChapterId, targetedForm);

	// --- Processing desc changes ---
	fieldToBeChanged = 'desc';
	valueToBeUpdated = updatedChapterDesc;
	processingField(fieldToBeChanged, valueToBeUpdated, updatedChapterId, targetedForm);
}

