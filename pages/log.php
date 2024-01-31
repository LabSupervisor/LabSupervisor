<?php
require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_header.php");
mainHeader("Log");
?>

<link rel="stylesheet" href="../public/css/log.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css">

<?php
require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_getDBLog.php");
?>

<?php
if (isset($_GET["trace"])) {
?>
    <body>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <td>ID</td>
                        <td>Utilisateur</td>
                        <td>Message</td>
                        <td>Date</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $logs = getDBLog();

                    foreach ($logs as $line) {
                        echo "<tr>";
                        echo '<th class="col1">' . $line["id"] . '</th>';
                        echo '<td class="col2">' . getName($line["iduser"]) . '</td>';
                        echo '<td class="col3-container">';
                        echo '<div class="col3-tooltip">' . htmlspecialchars($line["message"]) . '</div>';
                        echo '<div class="col3">' . $line["message"] . '</div>';
                        echo '</td>';
                        echo '<td class="col4">' . $line["date"] . '</td>';
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>

            <div class="button-container">
                <a href="<?= "http://" . $_SERVER["SERVER_NAME"] . "/pages/log.php?trace" ?>">
                    <button><i class="ri-draft-line"></i> Trace</button>
                </a>
                <a href="<?= "http://" . $_SERVER["SERVER_NAME"] . "/pages/log.php?error" ?>">
                    <button><i class="ri-error-warning-line"></i> Erreur</button>
                </a>
            </div>
        </div>
<?php
} else if (isset($_GET["error"])) {
    if (!isset($_GET["date"])) {
        $date = date("Y-m-d");
    } else {
        $date = $_GET["date"];
    }

    $file = $_SERVER["DOCUMENT_ROOT"] . "/logs/" . $date . ".log";
    if (file_exists($file)) {
        $logs = file_get_contents($file);
        $logs = explode("\n", $logs);
?>
        <div class="table-container2">
            <table>
                <thead>
                    <tr>
                        <th>Erreur</th>
                        <th>Message</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($logs as $line) {
                        $date = "";
                        $error = "";
                        $message = "";
                        $datePattern = "/\[(.*?)\]/";
                        $errorPattern = "/\](.*?)\:/";
                        $messagePattern = "/: (.*)$/";

                        if (preg_match($datePattern, $line, $matches))
                            $date = $matches[1];
                        if (preg_match($errorPattern, $line, $matches))
                            $error = $matches[1];
                        if (preg_match($messagePattern, $line, $matches))
                            $message = $matches[1];

                        echo "<tr>";
                        echo "<td class='col1'>" . $error . "</td>";
                        echo "<td class='col3-container'>";
                        echo '<div class="col3-tooltip">' . htmlspecialchars($message) . '</div>';
                        echo '<div class="col3">' . $message . '</div>';
                        echo "</td>";
                        echo "<td class='col2'>" . $date . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>

            <div class="button-container">
				<div class="left-buttons">
					<a href="http://labsupervisor.fr/pages/log.php?trace">
						<button><i class="ri-draft-line"></i> Trace</button>
					</a>
					<a href="http://labsupervisor.fr/pages/log.php?error">
						<button><i class="ri-error-warning-line"></i> Erreur</button>
					</a>
				</div>
				<div class="right-buttons">
					<form method="get">
						<input type="hidden" name="error">
						<input type="date" name="date">
						<input type="submit" value="Envoyer">
					</form>
				</div>
			</div>


        </div>
		</body>

		<?php
    } else {
        echo "Fichier introuvable";
?>
       <div class="PageErreur">
			<form method="get">
			<input type="hidden" name="error">
			<input type="date" name="date">
			<input type="submit" value="Envoyer">
			</form>
		</div>
<?php
    }
}
?>
