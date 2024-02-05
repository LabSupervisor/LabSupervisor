const express = require("express");
const http = require("http");
const { Server } = require("socket.io");

const app = express();
const server = http.createServer(app);
const io = new Server(server, {
	cors: {
		origin: "*",
		methods: ["GET", "POST"],
	},
});

io.on("connection", socket => {
	function log(text) {
		console.log(socket.id + " " + text);
	}

	log("Client connected!");

	socket.on("share", data => {
		socket.broadcast.emit("new", data);
	});

	socket.on("disconnect", () => {
		log("Client disconnected!");
	});
});

const PORT = process.env.PORT || 3000;

server.listen(PORT, () => {
	console.log("Server listening on port " + PORT);
});
