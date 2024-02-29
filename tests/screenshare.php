<?php
	require($_SERVER['DOCUMENT_ROOT'] . '/logic/ft_header.php');
	mainHeader("Screenshare Test");
?>

	<button id="share">Share</button>
	<div id="videogrid"></div>

	<script src="http://cdnjs.cloudflare.com/ajax/libs/peerjs/1.5.2/peerjs.min.js"></script>
	<script src="http://cdnjs.cloudflare.com/ajax/libs/socket.io/4.7.4/socket.io.js"></script>
	<script src="../public/js/screenShareEngine.js"></script>
