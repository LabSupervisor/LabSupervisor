<?php
// Define the WebSocket server address
$websocket_server = "ws://localhost:3000";

// HTML content with JavaScript to handle WebSocket
echo <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WebSocket Live Stream</title>
</head>
<body>

<canvas id="liveStreamCanvas" width="640" height="480" style="border: 1px solid #000;"></canvas>

<script>
// Connect to the WebSocket server
const websocket = new WebSocket('$websocket_server');

// Get the canvas element and its context
const canvas = document.getElementById('liveStreamCanvas');
const ctx = canvas.getContext('2d');

// Handle WebSocket messages
websocket.onmessage = function (event) {
    console.log('WebSocket message received:', event);

    // Create a blob object from the received binary data
    const blob = new Blob([event.data], { type: 'image/jpeg' });

    // Create a data URL for the blob
    const imageUrl = URL.createObjectURL(blob);

    console.log('Image URL:', imageUrl);

    // Draw the image on the canvas
    const image = new Image();
    image.src = imageUrl;

    // Clear the canvas before drawing
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    // Draw the image on the canvas
    image.onload = function () {
        console.log('Image loaded successfully');
        ctx.drawImage(image, 0, 0, canvas.width, canvas.height);
    };
};

// Handle WebSocket close event
websocket.onclose = function (event) {
    console.log('WebSocket closed:', event);
};

// Handle WebSocket error event
websocket.onerror = function (error) {
    console.error('WebSocket error:', error);
};
</script>

</body>
</html>
HTML;
?>
