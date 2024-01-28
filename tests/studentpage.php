<?php
//Connect to DB
session_start();
require '../config/db.php';
$db = dbConnect();

$message = '';
$iduser = 2;
$sql = "SELECT id, title FROM chapter";
$result = $db->query($sql);
$chapters = $result->fetchAll(PDO::FETCH_ASSOC);
if ($_SERVER["REQUEST_METHOD"] == "POST") { // A CHANGER !!!
    if (isset($_POST['help'])) {
        //Update db with state 1 -> HELP
        $sql = "UPDATE status SET state = 1  WHERE idchapter = 1   AND iduser = $iduser";
        $db->query($sql);
        $message = "Vous avez demandé a l'aide !";
    } elseif (isset($_POST['progress'])) {
        //Update db with state 2 -> PROGRESS
        $sql = "UPDATE status SET state = 2 WHERE idchapter = 1 AND iduser = $iduser";
        $db->query($sql);
        $message = "Votre travail est en cours !";
    } elseif (isset($_POST['finish'])) {
        //Update db with state 3 -> FINISH
        $sql = "UPDATE status SET state = 3 WHERE idchapter = 1 AND iduser = $iduser";
        $db->query($sql);
        $message = "Votre travail est terminé !";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suivi d'avancement </title>
</head>
<body>
<h2>Modifié votre Status </h2>
<form action="" method="post">
    <select size="1" name="liste">
        <?php foreach ($chapters as $chapter) : ?>
            <option value="<?php echo $chapter['id']; ?>"><?php echo $chapter['title']; ?></option>
            vardump($chapter['id']);
        <?php endforeach; ?>
    </select>
    <input type="submit" name="help" value="Besoin d'aide">
    <input type="submit" name="progress" value="Travail en cours">
    <input type="submit" name="finish" value="Travail terminé">
</form>

<?php echo $message; ?>
</body>
</html>
