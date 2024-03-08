<?php
// Connexion à la BDD
require($_SERVER["DOCUMENT_ROOT"] . '/config/config.php');

$db = dbConnect();

$queryIdUser = "SELECT id FROM user WHERE email = 'admin@labsupervisor.com' ";

$queryIdUserPrep = $db->prepare($queryIdUser) ;

if ($queryIdUserPrep->execute()) {
	// Récupérer la colonne 'id' en tant que chaîne de caractères
	$userId = $queryIdUserPrep->fetchColumn();

	if ($userId !== false) {
		echo "Session enregistrée avec succès. L'ID de l'utilisateur est : " . $userId;
	} else {
		echo "Aucun résultat trouvé.";
	}
}
