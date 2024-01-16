const shareButton = document.getElementById('share');
const grid = document.getElementById('videogrid');
const socket = io('ws://localhost:3000');

function addVideoStream(mediaStream) {
	const video = document.createElement('video');
	video.srcObject = mediaStream;
	grid.appendChild(video);
	video.play();
}

shareButton.addEventListener('click', async () => {
	const localStream = await navigator.mediaDevices.getDisplayMedia({ video: true, audio: false });
	addVideoStream(localStream);
	const peer = new Peer();
	socket.on('neww', data => {
		const call = peer.call(data, localStream);
		call.on('stream', stream => {
			addVideoStream(stream);
		});
	});
	peer.on('call', call => {
		call.answer(localStream);
	});
	peer.on('open', function (id) {
		console.log('Personal peer ID: ' + id);
		socket.emit('share', id);
	});
});
