const videoElement = document.getElementById("videoFrame");

const socket = new WebSocket("ws://localhost:3000");
socket.addEventListener('open', (event) => {
	console.log('Connexion WebSocket établie avec succès');
});

socket.addEventListener('message', (event) => {
	console.log("receive" + event.data);
	videoElement.srcObject = event.data;
});
