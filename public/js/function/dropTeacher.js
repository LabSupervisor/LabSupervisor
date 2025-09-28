/** ***** */
/** Utils */
/** ***** */

/**
 *
 * Creates a div element for a possible teacher.
 *
 * @param {number} teacherId - The ID of the possible teacher.
 * @param {string} name - The name of the possible teacher.
 * @param {string} surname - The surname of the possible teacher.
 * @returns a <div> element
 */
function createPossibleTeacherDiv(teacherId, name, surname) {
	// Creates the possible teacher div
	let possibleTeacherDiv = document.createElement("div");
	possibleTeacherDiv.setAttribute("id", "teacher-" + teacherId);
	possibleTeacherDiv.setAttribute("class", "teacher-row");
	// Creates the span element with name and surname of the teacher
	let teacherSpan = document.createElement("span");
	teacherSpan.textContent = name + " " + surname;
	possibleTeacherDiv.appendChild(teacherSpan);
	// Creates the i element with the add button
	let teacherI = document.createElement("i");
	teacherI.setAttribute("class", "ri-add-circle-fill");
	teacherI.setAttribute(
		"onclick",
		"addTeacher(" + teacherId + ", '" + name + "', '" + surname + "')"
	);
	// Addition of the add button
	possibleTeacherDiv.appendChild(teacherI);

	return possibleTeacherDiv;
}

/** **** */
/** Core */
/** **** */

/**
 * Removes a teacher from the session.
 *
 * This function performs the following steps:
 * 1. Removes the teacher div from the list of teachers in the container div.
 * 2. Remove the teacher to the list of teachers to add by deleting the hidden input (if present) in the addition teacher form
 * 3. Adds the teacher to the list of teachers to remove by using a hidden input in the remove teacher form.
 * 4. Add the teacher to the list of possible teachers to add in the right container div
 *
 * Description of the different cases:
 * - If the teacher is the last of the container, a message is displayed and the function returns.
 * - If the teacher is not already in the list of teachers to remove, it is added to the dropTeachers list AND if
 *   it is present in the actualTeachers list, because it is useless to add it to the dropTeachers list if it's not
 *   present in the actualTeachers list.
 *
 * @param {number} teacherId - The ID of the teacher to be removed.
 * @param {string} name - The name of the teacher to be removed.
 * @param {string} surname - The surname of the teacher to be removed.
 */
function dropTeacher(teacherId, name, surname) {
	// Step 0 : checks
	let teacherContainer = document.getElementById("teachersession");
	// if the teacher is the last of the container
	if (teacherContainer.childElementCount == 1) {
		// Do nothing ! And write a message "You need at least one teacher in the session"
		popupDisplay(lang('SESSION_REMOVE_LAST_TEACHER'));
		return;
	} else {
		// Step 1
		// Delete the teacher div from the list of teachers
		teacherContainer.removeChild(
			document.querySelector("#teacher-" + teacherId)
		);
		// Step 2
		// Remove the teacher to the list of teachers to add (if it's the case)
		let addedTeachersInput = document.querySelector(
			'input[name="addedTeachers[]"][value="' + teacherId + '"]'
		);
		// If the teacher was present in the list of teachers to add
		if (addedTeachersInput != null) {
			// Delete the corresponding hidden input
			addedTeachersInput.remove();
		} else {
			// if it was not present and it is present in the list of actual teachers
			let actualTeachersInput = document.querySelector(
				'input[name="actualTeachers[]"][value="' + teacherId + '"]'
			);
			if (actualTeachersInput != null) {
				// Step 3
				// Add the teacher to the list of teachers to remove if it is not already present
				let removedTeachersInput = document.querySelector(
					'input[name="removedTeachers[]"][value="' + teacherId + '"]'
				);
				// If the teacher is not already in the list of teachers to remove
				if (removedTeachersInput == null) {
					// Creates the hidden input to add the teacher to the list of teachers to remove
					let removedTeachersInput = document.createElement("input");
					removedTeachersInput.setAttribute("type", "hidden");
					removedTeachersInput.setAttribute(
						"name",
						"removedTeachers[]"
					);
					removedTeachersInput.setAttribute("value", teacherId);
					document
						.querySelector("#formSession")
						.appendChild(removedTeachersInput);
				}
			}
		}
		// Step 4
		// Add the teacher to the list of possible teachers to add
		// Create the possible teacher div
		let possibleTeacherDiv = createPossibleTeacherDiv(
			teacherId,
			name,
			surname
		);
		// Addition of the teacher div to the container
		document
			.getElementById("possible-teachers-container")
			.appendChild(possibleTeacherDiv);
	}
}
