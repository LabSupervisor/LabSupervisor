/**
 * Delete a teacher from a session
 * @param {*} button
 */
function dropTeacher(teacherId) {
    console.log("dropTeacher(teacherId) : " + teacherId);
    /*
    3 Steps in order to remove a teacher from a session
        1. Get the teacher ID from the function parameter
        2. Remove the teacher div from the list of teachers in the container div
        3. Add the teacher to the list of teachers to remove by using a hidden input in the remove teacher form
    */
    // Step 2
    let teacherContainer = document.querySelector("#teachersession");
    // Delete the teacher div from the list of teachers
    teacherContainer.removeChild(
        document.querySelector("#teacher-" + teacherId)
    );
    // Step 3
    // Add the teacher to the list of teachers to remove
    let removedTeachersInput = document.createElement("input");
    removedTeachersInput.setAttribute("type", "hidden");
    removedTeachersInput.setAttribute("name", "removedTeachers[]");
    removedTeachersInput.setAttribute("value", teacherId);
    document.querySelector("#formSession").appendChild(removedTeachersInput);

    console.log(
        "Teacher " +
            teacherId +
            " removed from the session. Still need to save the session to apply the changes."
    );
}
