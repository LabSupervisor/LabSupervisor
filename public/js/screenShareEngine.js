const videoElement = document.getElementById("videoFrame");
const startElement = document.getElementById("startScreenShare");
const stopElement = document.getElementById("stopScreenShare");

// const socket = new WebSocket("ws://localhost:3000");
// socket.addEventListener('open', (event) => {
// 	console.log('Connexion WebSocket établie avec succès');
// 	// Vous pouvez envoyer des messages au serveur ici, si nécessaire
// 	// socket.send('Bonjour, serveur WebSocket!');
// });

var displayMediaOptions = {
	video: {
		cursor: "always"
	},
	audio: false
};

startElement.addEventListener("click", function () {
	startCapture();
});

stopElement.addEventListener("click", function () {
	stopCapture();
});

async function startCapture() {
	try {
		videoElement.srcObject = await navigator.mediaDevices.getDisplayMedia(displayMediaOptions);

		// socket.send(JSON.stringify(navigator.mediaDevices.getDisplayMedia(displayMediaOptions)));
	} catch (error) {
		console.error("Error: " + error);
	}
}

function stopCapture() {
	let tracks = videoElement.srcObject.getTracks();
	tracks.forEach(track => track.stop());
	videoElement.srcObject = null;
}
