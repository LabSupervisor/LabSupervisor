<?php
//Connect to DB
session_start();
require '../config/db.php';
$db = dbConnect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = ($_POST['password']);

    $sql = "SELECT * FROM user WHERE email=:username ";
    $stmt = $db->prepare($sql);
    $stmt->bindparam("username", $username, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
//Checking if user and password match
    if ($user && isset($user['password'])) {
        // This function checks if the plain text that has just been entered matches the hash that is in the database
        if (password_verify($password, $user['password'])) {
            // Kept info during session for the user
            $_SESSION['username'] = $username;
            header("Location: welcome.php");
        }
    } else {
        // In case of a invalid password or user
        echo "Invalid password or user";
    }
}
$db = null;
?>
