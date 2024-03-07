<?php
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/ft_header.php");
	mainHeader("Session en cours");

	permissionChecker(true, true, false, false);
?>

<?php
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/updateStatus.php");
	require($_SERVER["DOCUMENT_ROOT"] . "/logic/createLink.php");
?>

<script src="/public/js/ft_updateStatus.js"></script>

<h2>Modifier votre Statut </h2>

<form method="post" id="formupdate">
	<input type="hidden" name="chapter" value="0" id="chapter">
	<input type="hidden" name="status" value="0" id="status">
</form>

<table>
	<thead>
		<tr>
			<th>Chapitre</th>
			<th>Action</th>
			<th>Status</th>
		</tr>
	</thead>
	<tbody>

		<?php
			foreach (SessionRepository::getChapter($_SESSION["session"]) as $chapter) { ?>
			<tr>
				<td>
					<?php echo $chapter["title"]; ?>
				</td>
				<td>
					<input type="hidden" name="liste" value="<?php echo $chapter['id']; ?>">
					<button onclick="setStatus(<?=$chapter['id']?>,3)">Terminé !</button>
					<button onclick="setStatus(<?=$chapter['id']?>,2)">Travail en cours...</button>
					<button onclick="setStatus(<?=$chapter['id']?>,1)">J'ai besoin d'aide !</button>
				</td>
				<td>
					<?php
						echo SessionRepository::getStatus($chapter['id'], UserRepository::getId($_SESSION["login"]));
					?>
				</td>
			</tr>
		<?php
			}
		?>

	</tbody>
</table>

<?php
	if (UserRepository::getLink($_SESSION["login"])){
		echo "LS-LINK n°" . UserRepository::getLink($_SESSION["login"]);
	}
	echo "<br>LS-LINK : <form method='POST'><input type='number' name='number'/><input type='submit' name='link'/>";
?>
