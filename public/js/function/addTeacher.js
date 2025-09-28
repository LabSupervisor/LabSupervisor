/** ***** */
/** Utils */
/** ***** */

/**
 *
 * Creates a div element for a teacher.
 *
 * @param {number} teacherId - The ID of the teacher.
 * @param {string} name - The name of the teacher.
 * @param {string} surname - The surname of the teacher.
 * @returns a <div> element
 */
function createTeacherDiv(teacherId, name, surname) {
    // Creates the teacher div
    let teacherDiv = document.createElement("div");
    teacherDiv.setAttribute("id", "teacher-" + teacherId);
    teacherDiv.setAttribute("class", "teacher-row");
    let teacherSpan = document.createElement("span");
    teacherSpan.textContent = name + " " + surname;
    teacherDiv.appendChild(teacherSpan);
    let teacherI = document.createElement("i");
    teacherI.setAttribute("class", "ri-delete-bin-5-line");
    teacherI.setAttribute(
        "onclick",
        "dropTeacher(" + teacherId + ", '" + name + "', '" + surname + "')"
    );
    // Addition of the delete button
    teacherDiv.appendChild(teacherI);

    return teacherDiv;
}

/** **** */
/** Core */
/** **** */

/**
 * Adds a teacher to the session.
 *
 * This function performs four main steps:
 * 1. Remove the teacher to the list of possible teachers from the right container div
 * 2. Add the teacher to the list of teachers to add by using a hidden input in the addition teacher form.
 * 3. Add the teacher div to the list of teachers in the container div.
 * 4. Remove the teacher to the list of teachers to remove by deleting the hidden input (if present) in the remove teacher form
 *
 * Description of the different cases:
 * - Each time, remove the teacher from the list of possible teachers
 * - If the teacher is not already in the list of teachers to add, it is added to the addedTeachers list AND if
 *   it is not present in the actualTeachers list, because it is useless to add it to the addedTeachers list if it's already
 *   present in the actualTeachers list.
 *
 * @param {number} teacherId - The unique identifier of the teacher.
 * @param {string} name - The first name of the teacher.
 * @param {string} surname - The last name of the teacher.
 */
function addTeacher(teacherId, name, surname) {
    console.log("addTeacher(teacherId) : " + teacherId);
    // Step 1
    // Remove the teacher to the list of possible teachers
    let possibleTeacherDiv = document.getElementById("teacher-" + teacherId);
    if (possibleTeacherDiv != null) {
        // Delete the corresponding div
        possibleTeacherDiv.remove();
    }
    // Step 2
    // Add the teacher to the list of teachers to add ONLY if it's not already present in the actualTeachers list
    let actualTeachersInput = document.querySelector(
        'input[name="actualTeachers[]"][value="' + teacherId + '"]'
    );
    // If the teacher is not already present in the actualTeachers list
    if (actualTeachersInput == null) {
        let addedTeachersInput = document.createElement("input");
        addedTeachersInput.setAttribute("type", "hidden");
        addedTeachersInput.setAttribute("name", "addedTeachers[]");
        addedTeachersInput.setAttribute("value", teacherId);
        document.querySelector("#formSession").appendChild(addedTeachersInput);
    }

    // Step 3
    // Add the teacher div to the list of teachers
    // Create the teacher div
    let teacherDiv = createTeacherDiv(teacherId, name, surname);
    // Addition of the teacher div to the container
    document.querySelector("#teachersession").appendChild(teacherDiv);

    // Step 4
    // Remove the teacher to the list of teachers to remove
    let removedTeachersInput = document.querySelector(
        'input[name="removedTeachers[]"][value="' + teacherId + '"]'
    );
    if (removedTeachersInput != null) {
        // Delete the corresponding hidden input
        removedTeachersInput.remove();
    }

    console.log(
        "Teacher " +
            teacherId +
            " added to the session. Still need to save the session to apply the changes."
    );
}
