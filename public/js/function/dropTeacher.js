/**
 * Removes a teacher from the session.
 *
 * This function performs the following steps:
 * 1. Removes the teacher div from the list of teachers in the container div.
 * 2. Adds the teacher to the list of teachers to remove by using a hidden input in the remove teacher form.
 * 3. Remove the teacher to the list of teachers to add by deleting the hidden input (if present) in the addition teacher form
 * 4. Add the teacher to the list of possible teachers to add in the right container div
 * 
 * @param {number} teacherId - The ID of the teacher to be removed.
 * @param {string} name - The name of the teacher to be removed.
 * @param {string} surname - The surname of the teacher to be removed.
 */
function dropTeacher(teacherId, name, surname) {
    console.log("dropTeacher(teacherId) : " + teacherId);
    // Step 1
    let teacherContainer = document.getElementById("teachersession");
    // Delete the teacher div from the list of teachers
    teacherContainer.removeChild(
        document.querySelector("#teacher-" + teacherId)
    );
    // Step 2
    // Add the teacher to the list of teachers to remove
    let removedTeachersInput = document.createElement("input");
    removedTeachersInput.setAttribute("type", "hidden");
    removedTeachersInput.setAttribute("name", "removedTeachers[]");
    removedTeachersInput.setAttribute("value", teacherId);
    document.querySelector("#formSession").appendChild(removedTeachersInput);

    // Step 3
    // Remove the teacher to the list of teachers to add
    let addedTeachersInput = document.querySelector(
        'input[name="addedTeachers[]"][value="' + teacherId + '"]'
    );
    if (addedTeachersInput != null) {
        // Delete the corresponding hidden input
        addedTeachersInput.remove();
    }

    // Step 4
    // Add the teacher to the list of possible teachers to add
    let possibleTeachersContainer = document.getElementById("possible-teachers-container");
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
    teacherI.setAttribute("onclick", "addTeacher(" + teacherId + ", '" + name + "', '" + surname + "')");
    // Addition of the add button
    possibleTeacherDiv.appendChild(teacherI);
    // Addition of the teacher div to the container
    possibleTeachersContainer.appendChild(possibleTeacherDiv);

    console.log(
        "Teacher " +
            teacherId +
            " removed from the session. Still need to save the session to apply the changes."
    );
}
