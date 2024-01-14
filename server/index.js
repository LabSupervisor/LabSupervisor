const WebSocket = require('ws');

const server = new WebSocket.Server({ port: 3000 });

server.on('connection', (socket) => {
	console.log('Nouvelle connexion WebSocket établie');

	socket.on('message', (message) => {
		console.log(`Message reçu: ${message}`);
	});

	socket.on('close', () => {
		console.log('Connexion WebSocket fermée');
	});
});
