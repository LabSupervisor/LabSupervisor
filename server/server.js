const express = require("express");
const http = require("http");
const { Server } = require("socket.io");

const app = express();
const server = http.createServer(app);

// Create server
const io = new Server(server, {
	cors: {
		origin: "*",
		methods: ["GET", "POST"],
	},
});

// On client connect
io.on("connection", socket => {
	function log(text) {
		console.log(socket.id + " " + text);
	}

	log("Client connected!");

	// Emit screenshare
	socket.on("share", data => {
		socket.broadcast.emit("new", data);
	});

	// On client disconnect
	socket.on("disconnect", () => {
		log("Client disconnected!");
	});
});

const PORT = process.env.PORT || 3000;

// Log server port
server.listen(PORT, () => {
	console.log("Server listening on port " + PORT);
});
