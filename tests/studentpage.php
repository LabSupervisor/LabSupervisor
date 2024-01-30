<?php
//Connect to DB
session_start();
require '../config/db.php';
$db = dbConnect();

$message = '';
$iduser = 2;
$sql = "SELECT id, title FROM chapter  WHERE idsession = 1";
$result = $db->query($sql);
$chapters = $result->fetchAll(PDO::FETCH_ASSOC);
/*if ($_SERVER["REQUEST_METHOD"] == "POST") { // ID CHAPTER A CHANGER !!!
    if (isset($_POST['help'])) {
        //Update db with state 1 -> HELP
        $sql = "UPDATE status SET state = 1  WHERE idchapter = 1   AND iduser = $iduser";
        $db->query($sql);
        $message = "Vous avez demandé a l'aide ";
    } elseif (isset($_POST['progress'])) {
        //Update db with state 2 -> PROGRESS
        $sql = "UPDATE status SET state = 2 WHERE idchapter = 1 AND iduser = $iduser";
        $db->query($sql);
        $message = "Votre travail est en cours ";
    } elseif (isset($_POST['finish'])) {
        //Update db with state 3 -> FINISH
        $sql = "UPDATE status SET state = 3 WHERE idchapter = 1 AND iduser = $iduser";
        $db->query($sql);
        $message = "Votre travail est terminé ";
    }
}*/
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suivi d'avancement </title>
</head>

<script>
    //La méthode met a jours le formulaire et l'envoie
    function SetStatus(idchapter,statut){
        document.getElementById("chapters").value = idchapter;
        document.getElementById("statut").value = statut;
        let form = document.getElementById("formupdate");
        form.submit();
    }
</script>
<body>
<h2>Modifié votre Status </h2>
<form action="" method="post" id="formupdate">
    <input type="hidden" name="user" value="<?php echo $iduser ?>">
    <input type="hidden" name="chapters" value="0" id="chapters">
    <input type="hidden" name="statut" value="0" id="statut">
</form>
<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $idUser = $_POST['user'];
        $idChapter = $_POST['chapters'];
        $statut = $_POST['statut'];
        $sql1 = "UPDATE status SET state = :statut WHERE idchapter = :idChapter AND iduser = :idUser";
        $stmt = $db->prepare($sql1);
        $stmt->bindParam(':status', $statut);
        $stmt->bindParam(':idChapter', $idChapter);
        $stmt->bindParam(':idUser', $idUser);
        $stmt->execute();
    }
        ?>
    <table>
        <thead>
        <tr>
            <th>Chapitre</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($chapters as $chapter) : ?>
            <tr>
                <td><?php echo $chapter['title']; ?></td>
                <td>
                    <input type="hidden" name="liste" value="<?php echo $chapter['id']; ?>">
                    <button onclick="SetStatus(<?php echo $chapter['id']?>,1)">A l'aide</button>
                    <button onclick="SetStatus(<?php echo $chapter['id']?>,2)">En cours</button>
                    <button onclick="SetStatus(<?php echo $chapter['id']?>,3)">Finis</button>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

<?php
?>
</body>
</html>