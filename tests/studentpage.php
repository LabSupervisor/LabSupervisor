<?php
//Connect to DB
session_start();
require '../config/db.php';
$db = dbConnect();
//taking info from db with the session
$iduser = 2;
$sql = "SELECT id, title FROM chapter  WHERE idsession = 1";
$result = $db->query($sql);
$chapters = $result->fetchAll(PDO::FETCH_ASSOC);
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
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$idUser = $_POST['user'];
	$idChapter = $_POST['chapters'];
	$Statut = $_POST['statut'];
	$sqlUp = "UPDATE status SET state = :Statut WHERE idchapter = :idChapter AND iduser = :idUser";
	$stmt = $db->prepare($sqlUp);
	$stmt->bindParam(':Statut', $Statut);
	$stmt->bindParam(':idChapter', $idChapter);
	$stmt->bindParam(':idUser', $idUser);
	$stmt->execute();
}
?>
<body>
<h2>Modifié votre Statut </h2>
<form action="" method="post" id="formupdate">
    <input type="hidden" name="user" value="<?php echo $iduser ?>">
    <input type="hidden" name="chapters" value="0" id="chapters">
    <input type="hidden" name="statut" value="0" id="statut">
</form>
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
                <td>
                    <?php
                        $sqlstate = "SELECT state FROM status WHERE idchapter = :idChapter AND iduser = :idUser";
                        $stmtState = $db->prepare($sqlstate);
                        $stmtState->bindParam(':idChapter', $chapter['id']);
                        $stmtState->bindParam(':idUser', $iduser);
                        $stmtState->execute();
                        $state = $stmtState->fetch(PDO::FETCH_COLUMN);
                        echo $state;
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>

        </tbody>
    </table>

<?php
?>
</body>
</html>