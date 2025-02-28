/**
 * Adds a teacher to the session.
 *
 * This function performs four main steps:
 * 1. Remove the teacher to the list of possible teachers from the right container div
 * 2. Add the teacher div to the list of teachers in the container div.
 * 3. Add the teacher to the list of teachers to add by using a hidden input in the addition teacher form.
 * 4. Remove the teacher to the list of teachers to remove by deleting the hidden input (if present) in the remove teacher form
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
    let teacherContainer = document.querySelector("#teachersession");
    // Add the teacher div to the list of teachers

    let teacherDiv = document.createElement("div");
    teacherDiv.setAttribute("id", "teacher-" + teacherId);
    teacherDiv.setAttribute("class", "teacher-row");
    let teacherSpan = document.createElement("span");
    teacherSpan.textContent = name + " " + surname;
    teacherDiv.appendChild(teacherSpan);
    let teacherI = document.createElement("i");
    teacherI.setAttribute("class", "ri-delete-bin-5-line");
    teacherI.setAttribute("onclick", "dropTeacher(" + teacherId + ", '" + name + "', '" + surname + "')");
    // Addition of the delete button
    teacherDiv.appendChild(teacherI);
    // Addition of the teacher div to the container
    teacherContainer.appendChild(teacherDiv);

    // Step 3
    // Add the teacher to the list of teachers to add
    let addedTeachersInput = document.createElement("input");
    addedTeachersInput.setAttribute("type", "hidden");
    addedTeachersInput.setAttribute("name", "addedTeachers[]");
    addedTeachersInput.setAttribute("value", teacherId);
    document.querySelector("#formSession").appendChild(addedTeachersInput);

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
