<!-- dashboard.php -->

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Video Dashboard</title>
</head>
<body>
  <!-- Display the live video -->
  <video id="liveVideo" controls></video>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.0.1/socket.io.js"></script>
  <script>
    const socket = io('http://localhost:3000');
    const liveVideo = document.getElementById('liveVideo');

    // Receive video updates from the server
    socket.on('updateVideo', (data) => {
      // Update the video source with the received data
      // Assume data is a valid video source, you may need to adjust this based on your implementation
      liveVideo.src = data;
    });
  </script>
</body>
</html>
