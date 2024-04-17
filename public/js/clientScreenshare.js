const shareButton = document.getElementById('shareButton');
const grid = document.getElementById('videogrid');
const socket = io('ws://localhost:3000');
let data = [];

// Start sharing
shareButton.addEventListener('click', async () => {
	// Ask web browser
	const mediaStream = await navigator.mediaDevices.getDisplayMedia({
		video: {
			displaySurface: 'monitor'
		},
		audio: false
	});

	// Create peer connection
	const peer = new Peer();

	// Listen
	peer.on('call', call => {
		call.answer(mediaStream);
	});

	// Create peer connection
	peer.on('open', function (id) {
		console.log('Personal peer ID: ' + id);
		socket.emit('share', [userId, id]);
	});

	socket.emit('screenshare', data => {
		peer.call(data, mediaStream);
	});
});
