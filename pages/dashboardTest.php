<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Página</title>
    <link rel="stylesheet" href="..\public\css\dashboard.css">
</head>
<body>

<div id="preview-container"></div>

<script>
	//Tu peux effacer ça, cetait pour avoir les ususaires de l'autre TP
		document.addEventListener("DOMContentLoaded", function() {
		// Utilisateurs prédéfinis
		var users = [
			{ Nom_Utilisateur: "Alice", Prenom_Utilisateur: "Wonderland", etat: "Finalisé" },
			{ Nom_Utilisateur: "Bob", Prenom_Utilisateur: "Builder", etat: "En Difficulté" },
			{ Nom_Utilisateur: "Charlie", Prenom_Utilisateur: "Chocolate", etat: "En Cours" },
			{ Nom_Utilisateur: "David", Prenom_Utilisateur: "Dynamite", etat: "Finalisé" },
			{ Nom_Utilisateur: "Eva", Prenom_Utilisateur: "Explorer", etat: "En Cours" },
			{ Nom_Utilisateur: "Frank", Prenom_Utilisateur: "Fantastic", etat: "En Difficulté" },
			{ Nom_Utilisateur: "Alberto", Prenom_Utilisateur: "Gonzales", etat: "Finalisé" },
			{ Nom_Utilisateur: "Oliver", Prenom_Utilisateur: "Benji", etat: "" },
			{ Nom_Utilisateur: "Jean", Prenom_Utilisateur: "Pol", etat: "Finalisé" }
		];
			// Afficher les utilisateurs
			displayUsers(users);
		});
    //-------------------------------------------------------------------

    function displayUsers(users) {
    var previewContainer = document.getElementById("preview-container");

    // Ajout des utilisateurs existants
    users.forEach(function (user, index) {
        var userCell = document.createElement("div");
        userCell.className = "user-cell";
        userCell.id = "user-" + index;

        // Ajout d'une balise img avec un exemple de chemin d'image
        var imgElement = document.createElement("img");
        imgElement.src = "../public/img/ImageNA.jpg";
        imgElement.alt = "Image de l'utilisateur";

        // Ajout du nom de l'utilisateur
        var nameElement = document.createElement("p");
        nameElement.textContent = user.Nom_Utilisateur + " " + user.Prenom_Utilisateur;

        // Ajout des boules d'état
        var statusBalls = createStatusBalls(user.etat);

        // Création de deux divs pour aligner le nom et les boules en ligne
        var nameAndBallsContainer = document.createElement("div");
        nameAndBallsContainer.className = "name-and-balls-container";

        // Ajout des éléments à la div du nom et des boules
        nameAndBallsContainer.appendChild(nameElement); // Ajout du nom d'utilisateur
        nameAndBallsContainer.appendChild(statusBalls); // Ajout des boules d'état à la div

        // Ajout des éléments à la cellule
        userCell.appendChild(imgElement); // Ajout de l'image qui sera le partage video
        userCell.appendChild(nameAndBallsContainer); // Ajout de la div du nom et des boules à la cellule

        // Ajout de la cellule de l'utilisateur au conteneur
        previewContainer.appendChild(userCell);
    });

    // Ajout d'une cellule pour inviter de nouveaux utilisateurs
    var inviteCell = document.createElement("div");
    inviteCell.className = "user-cell";

    // Ajout d'une balise img avec un exemple de chemin d'image pour l'invitation
    var inviteImgElement = document.createElement("img");
    inviteImgElement.src = "../public/img/Invit.png";
    inviteImgElement.alt = "Inviter de nouveaux utilisateurs";

    // Ajout d'un message d'invitation
    var inviteMessageElement = document.createElement("p");
    inviteMessageElement.textContent = "Inviter nouveaux utilisateurs";

    // Ajout des éléments à la cellule d'invitation
    inviteCell.appendChild(inviteImgElement);
    inviteCell.appendChild(inviteMessageElement);

    // Ajout de la cellule d'invitation à la fin du conteneur
    previewContainer.appendChild(inviteCell);
}

	// Fonction pour créer les boules d'état en fonction de l'état de l'utilisateur
	function createStatusBalls(etat) {
		var statusBallsContainer = document.createElement("div");

		// Toujours afficher les trois boules d'état
		var finishedBall = createStatusBall("status-Finished", etat === "Finalisé");
		var workingBall = createStatusBall("status-Working", etat === "En Cours");
		var troubleBall = createStatusBall("status-In-trouble", etat === "En Difficulté");

		statusBallsContainer.appendChild(finishedBall);
		statusBallsContainer.appendChild(workingBall);
		statusBallsContainer.appendChild(troubleBall);	

		return statusBallsContainer;
	}

	// Fonction pour créer une boule d'état avec la classe spécifiée
	function createStatusBall(statusClass, isActive) {
		var statusBall = document.createElement("div");
		statusBall.className = "status-ball " + statusClass + (isActive ? " active" : "");
		return statusBall;
	}
	

	// Fonction pour obtenir la classe d'état en fonction de l'état de l'utilisateur
	function getStatusClass(etat) {
		switch (etat) {
			case "Finalisé":
				return "status-Finished";
			case "En Difficulté":
				return "status-In-trouble";
			case "En Cours":
				return "status-Working";
		}
	}

</script>

</body>
</html>