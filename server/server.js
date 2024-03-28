const express = require("express");
const http = require("http");
const { Server } = require("socket.io");

const app = express();
const server = http.createServer(app);

let activeScreenshare = [];

// Create server
const io = new Server(server, {
	cors: {
		origin: "*",
		methods: ["GET", "POST"],
	},
});

// On client connect
io.on("connection", socket => {
	console.log(socket.id + " connected!");

	// On client disconnect
	socket.on("disconnect", () => {
		console.log(socket.id + " disconnected!");
		// TODO Remove connection uuid from list
	});

	// Listen to coming screenshare
	socket.on("share", data => {
		// Store screenshare peer id
		activeScreenshare[data[0]] = data[1];
		console.log(activeScreenshare);
	});

	// Listen to screenshare ask
	socket.on("get", id => {
		// Transfer screenshare peer id
		console.log("Screenshare ask: " + id);
		socket.emit("response", activeScreenshare[id]);
	})
});

const PORT = process.env.PORT || 3000;

// Log server port
server.listen(PORT, () => {
	console.log("Server listening on port " + PORT);
});
