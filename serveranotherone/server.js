// server.js

const express = require('express');
const http = require('http');
const socketIO = require('socket.io');
const fs = require('fs');

const app = express();
const server = http.createServer(app);
const io = socketIO(server, { 
	cors: {    
		origin: "*",    
		methods: ["GET", "POST"]  
	}
});

app.use(express.static(__dirname + '/public'));

io.on('connection', (socket) => {
  console.log('Client connected');

  // Écoutez les données vidéo provenant de la page emit.php
  socket.on('videoData', (data) => {
    // Diffusez les données vidéo à tous les clients connectés (par exemple, dashboard.php)
    io.emit('updateVideo', data);
  });

  socket.on('disconnect', () => {
    console.log('Client disconnected');
  });
});

server.listen(3000, () => {
  console.log('Server is running on port 3000');
});
