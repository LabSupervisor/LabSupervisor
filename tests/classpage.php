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
    $studentName = $_POST['student_name'];
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
					<th>email</th>
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
					?>

                    <tr>
                        <td><?php
						$studInfos = getUserById($student['iduser']);
						$name = $studInfos['name'];
						$surname = $studInfos['surname'];
						$email = $studInfos['email'];
						echo "$name ";
						?></td>
						<td><?php
						echo "$surname ";
						?></td>
						<td><?php
						echo "$email ";
						?></td>

                    </tr>

					<tr>


                <?php endforeach; ?>
            </tbody>
        </table>
<?php
$sql = "SELECT name, surname FROM user";
$result = $db->query($sql);
$users = $result->fetchAll(PDO::FETCH_ASSOC);
?>

        <form action="" method="post">
    <?php endforeach; ?>
</body>
</html>

