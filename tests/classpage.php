<?php

require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_getClass.php");
require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_getUserbyId.php");
require $_SERVER['DOCUMENT_ROOT'] . "/config/db.php";
$db = dbConnect();
$sqlClasses = "SELECT * FROM classroom";
$resultClasses = $db->query($sqlClasses);
$classes = $resultClasses->fetchAll(PDO::FETCH_ASSOC);

// Process form submission to add students
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $classId = $_POST['class_id'];
    $studentId = $_POST['student_id'];

    // Add the student to the class in the database
    $sqlAddStudent = "INSERT INTO userclassroom (idclassroom, iduser) VALUES (:classId, :studentId)";
    $stmtAddStudent = $db->prepare($sqlAddStudent);
    $stmtAddStudent->bindParam(':classId', $classId);
    $stmtAddStudent->bindParam(':studentId', $studentId);
    $stmtAddStudent->execute();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter des élèves</title>
</head>
<body>
    <h2>Ajouter des élèves</h2>

    <?php foreach ($classes as $classroom) : ?>
        <h3>Classe <?php echo $classroom['name']; ?></h3>
        <table border="1">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <?php

                // Fetch students for the current class
                $classId = $classroom['id'];
                $sqlStudents = "SELECT iduser FROM userclassroom WHERE idclassroom = :idclassroom";
                $stmtStudents = $db->prepare($sqlStudents);
                $stmtStudents->bindParam(':idclassroom', $classId);
                $stmtStudents->execute();
                $students = $stmtStudents->fetchAll(PDO::FETCH_ASSOC);
                foreach ($students as $student) :
                    $studInfos = getUserById($student['iduser']);
                ?>

                    <tr>
                        <td><?php echo $studInfos['name']; ?></td>
                        <td><?php echo $studInfos['surname']; ?></td>
                        <td><?php echo $studInfos['email']; ?></td>
                    </tr>

                <?php endforeach; ?>
            </tbody>
        </table>

        <form action="" method="post">
            <input type="hidden" name="class_id" value="<?php echo $classroom['id']; ?>">
            <label for="student_id">Sélectionner un élève :</label>
            <select name="student_id" id="student_id">
                <?php
                // Fetch students not already in this class
				// Usefull line that i could used in register logic
                $sqlStudents = "SELECT * FROM user WHERE id NOT IN (SELECT iduser FROM userclassroom WHERE idclassroom = :classId)";
                $stmtStudents = $db->prepare($sqlStudents);
                $stmtStudents->bindParam(':classId', $classroom['id']);
                $stmtStudents->execute();
                $students = $stmtStudents->fetchAll(PDO::FETCH_ASSOC);
                foreach ($students as $student) {
                    echo "<option value='" . $student['id'] . "'>" . $student['name'] . " " . $student['surname'] . "</option>";
                }
                ?>
            </select>
            <input type="submit" value="Ajouter">
        </form>

    <?php endforeach; ?>
</body>
</html>
