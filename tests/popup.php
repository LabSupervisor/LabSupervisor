<?php
	require($_SERVER['DOCUMENT_ROOT'] . '/logic/ft_header.php');
	mainHeader("Popup Test");
?>

<script src="../public/js/ft_popupCenter.js"></script>

<a onclick="popupCenter({url: 'https://labsupervisor.fr/tests/screenshare.php', title: 'xtf', w: 900, h: 500})">
	<button>Ouvrir la fenêtre</button>
</a>
