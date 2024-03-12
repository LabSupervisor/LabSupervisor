const shareButton = document.getElementById('shareButton');
const grid = document.getElementById('videogrid');
const socket = io('ws://localhost:3000');
let data = [];

// Update video display
// function addVideoStream(mediaStream) {
// 	const video = document.createElement('video');
// 	video.srcObject = mediaStream;
// 	grid.appendChild(video);
// 	video.play();
// }

// Start sharing
shareButton.addEventListener('click', async () => {
	// Ask web browser
	const localStream = await navigator.mediaDevices.getDisplayMedia({ video: true, audio: false });
	// addVideoStream(localStream);

	// Create peer connection
	const peer = new Peer();
	socket.emit('screenshare', data => {
		// const call = peer.call(data, localStream);
		peer.call(data, localStream);
		// call.on('stream', stream => {
		// 	addVideoStream(stream);
		// });
	});

	// Check connection
	// peer.on('call', call => {
	// 	call.answer(localStream);
	// });

	// Log
	// peer.on('open', function (id) {
	// 	console.log('Personal peer ID: ' + id);
	// 	socket.emit('share', id);
	// });
});
