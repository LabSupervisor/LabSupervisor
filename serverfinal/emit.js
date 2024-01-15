const socket = new WebSocket('ws://localhost:3000');

socket.addEventListener('open', () => {
	console.log('Connexion WebSocket établie avec succès');
});

navigator.mediaDevices.getDisplayMedia({ video: true }).then((screenStream) => {
	const mediaRecorder = new MediaRecorder(screenStream);

	mediaRecorder.ondataavailable = (event) => {
		if (event.data.size > 0) {
			socket.send(event.data);
		}
	};

	mediaRecorder.start(1000);
}).catch((error) => {
	console.error('Erreur lors de la capture d\'écran:', error);
});
