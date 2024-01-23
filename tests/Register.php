<?php
//Connect to DB
session_start();
require '../config/db.php';
$db = dbConnect();
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form database
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $birthdate = $_POST['birthdate'];

// Check if the username is already taken
    $checkemailQuery = "SELECT * FROM user WHERE email=:email";
    $checkemailStmt = $db->prepare($checkemailQuery);
    $checkemailStmt->bindparam("email", $email);
    $checkemailStmt->execute();
    $checkemailResult = $checkemailStmt->fetch(PDO::FETCH_ASSOC);

    // Validate input
    if (empty($email) || empty($password) || empty($name) || empty($surname) || empty($birthdate)) {
        echo "All fields are required.";
    } elseif ($checkemailResult) {
        echo "Email already taken. Please choose another.";
    } else {
        // Registration logic
        // Insert form info into db
        $sql = "INSERT INTO user (email, password, name, surname, birthdate)
                        VALUES (:email, :password, :name, :surname, :birthdate)";
        $sql = $db->prepare($sql);
        $sql->bindParam(":email", $email);
        $sql->bindParam(":password", $password);
        $sql->bindParam(":name", $name);
        $sql->bindParam(":surname", $surname);
        $sql->bindParam(":birthdate", $birthdate);

        // Display success or failure message
        if ($sql->execute()) {
            echo "Registration successful for email: $email";
            echo "<br>";
            echo "You can now <a href='connexion.php'>login</a>.";
            var_dump($checkemailResult);
        } else {
            echo "Registration failed. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
</head>
<body>
<h2>User Registration</h2>
<form action="" method="post">
    Email: <input type="email" name="email" required><br>
    Password: <input type="password" name="password" required><br>
    Name: <input type="text" name="name" required><br>
    Surname: <input type="text" name="surname" required><br>
    Birthdate: <input type="date" name="birthdate" required><br>
    <input type="submit" value="Register">
</form>
</body>
</html>
