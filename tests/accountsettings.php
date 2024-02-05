<?php
    // Connect to DB
    session_start();
    require '../config/db.php';
    $db = dbConnect();

    $iduser = 2;

    // take all the known information from the db of the user
    $sql = "SELECT * FROM user WHERE id = :iduser";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':iduser', $iduser);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Checks if the form has been submitted to update the information
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $newName = $_POST['new_name'];
        $newSurname = $_POST['new_surname'];
        $newPassword = $_POST['new_password'];
        $confPassword = $_POST['conf_password'];
        // Sending to the db a new user if the form is not empty
        if (!empty($newName)) {
            $sqlUpdateName = "UPDATE user SET name = :name WHERE id = :iduser";
            $stmtUpdateName = $db->prepare($sqlUpdateName);
            $stmtUpdateName->bindParam(':name', $newName);
            $stmtUpdateName->bindParam(':iduser', $iduser);
            $stmtUpdateName->execute();
        }
        // Sending to the db a new name if the form is not empty
        if (!empty($newSurname)) {
            $sqlUpdateSurname = "UPDATE user SET surname = :surname WHERE id = :iduser";
            $stmtUpdateSurname = $db->prepare($sqlUpdateSurname);
            $stmtUpdateSurname->bindParam(':surname', $newSurname);
            $stmtUpdateSurname->bindParam(':iduser', $iduser);
            $stmtUpdateSurname->execute();  
        }
        if ($newPassword != $confPassword) {
            //checking if the password is the same in on the two form
            echo "Les mots de passes ne correspondent pas !";
        }
        else{
        // Sending to the db the new password using bcrypt algo if the form is not empty
        if (!empty($newPassword)) {
            $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
            $sqlUpdatePassword = "UPDATE user SET password = :password WHERE id = :iduser";
            $stmtUpdatePassword = $db->prepare($sqlUpdatePassword);
            $stmtUpdatePassword->bindParam(':password', $hashedPassword);
            $stmtUpdatePassword->bindParam(':iduser', $iduser);
            $stmtUpdatePassword->execute();
        }
    }
    }

    // take all the new info again from the database
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paramètres du compte</title>
</head>
<body>
<h2>Paramètres du compte</h2>
<form action="" method="post">
    <label for="new_name">Nouveau nom:</label>
    <input type="text" name="new_name" value="<?php echo $user['name']; ?>"><br>
    <label for="new_surname">Nouveau prénom:</label>
    <input type="text" name="new_surname" value="<?php echo $user['surname']; ?>"><br>
    <label for="new_password">Nouveau mot de passe:</label>
    <input type="password" name="new_password"><br>
    <label for="new_password">Veuillez confirmer:</label>
    <input type="password" name="conf_password"><br>
    <input type="submit" value="Enregistrer les modifications">
</form>
</body>
</html>
