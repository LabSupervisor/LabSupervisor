const getshareButton = document.getElementById('getScreenshare');
const grid = document.getElementById('screenshare');
const socket = io('ws://localhost:3000');

// Update video display
function addVideoStream(mediaStream) {
	const video = document.createElement('video');
	video.srcObject = mediaStream;
	grid.appendChild(video);
	video.play();
}

getshareButton.addEventListener('click', async () => {
	const mediaStream = await navigator.mediaDevices.getDisplayMedia({
		video: true,
		audio: false
	});

	// Create peer connection
	const peer = new Peer();

	// Create peer connection
	peer.on('open', function () {
		socket.emit('get', 14);
	});

	socket.on('response', id => {
		console.log(id);
		const call = peer.call(id, mediaStream);
		call.on('stream', stream => {
			addVideoStream(stream);
		});
	})
});
