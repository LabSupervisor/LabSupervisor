<?php

	use function
		LabSupervisor\functions\mainHeader,
		LabSupervisor\functions\lang;

	// Import header
	mainHeader(lang("FOOTER_ABOUT"), true);

?>

<link rel="stylesheet" href="/public/css/about.css">

<div class="mainbox">
	<h2><?= lang("FOOTER_ABOUT") . " " . lang("MAIN_TITLE")?></h2>

	<div class="line"></div>

	<h3><?= lang("ABOUT_STAFF") ?></h3>
	<div class="group">
		<div class="item">
			<p><a href="https://github.com/SkyWors" target="_blank"><i class="ri-external-link-line"></i> Erick Paoletti</a><br><span class="role">CEO Developer Designer</span></p>
			<p><a href="https://marine.gonnord.org" target="_blank"><i class="ri-external-link-line"></i> Marine Gonnord</a><br><span class="role">Developer</span></p>
			<p><a href="https://github.com/GautierTrp" target="_blank"><i class="ri-external-link-line"></i> Gautier Trapeau</a><br><span class="role">Developer</span></p>
		</div>
		<div class="item">
			<p>Eylann Jolivet<br><span class="role">LS-Link Developer</span></p>
			<p>Léo Pothin<br><span class="role">Network Engineer</span></p>
			<p>Hugo Bordas<br><span class="role">Network Engineer</span></p>
		</div>
	</div>

	<div class="line"></div>

	<h3><?= lang("ABOUT_HELP") ?></h3>
	<div class="group">
		<div class="item">
			<p><a href="https://killbinvlog.me" target="_blank"><i class="ri-external-link-line"></i> Aymeric M.</a><br><span class="role">Developer</span></p>
			<p><a href="https://geoffreygx.com" target="_blank"><i class="ri-external-link-line"></i> Geoffrey G.</a><br><span class="role">Designer</span></p>
		</div>
		<div class="item">
			<p>Nassim M.</a><br><span class="role">Logo Designer</span></p>
			<p>Baptiste T.</a><br><span class="role">LS-Link Designer</span></p>
		</div>
	</div>

	<div class="line"></div>

	<h3><?= lang("ABOUT_LIBRARY") ?></h3>
	<div class="group">
		<div class="item">
			<p><a href="https://peerjs.com/" target="_blank"><i class="ri-external-link-line"></i> PeerJS</a></p>
			<p><a href="https://github.com/vlucas/phpdotenv" target="_blank"><i class="ri-external-link-line"></i> PHPdotenv</a></p>
			<p><a href="https://phpunit.de/index.html" target="_blank"><i class="ri-external-link-line"></i> PHPUnit</a></p>
		</div>
		<div class="item">
			<p><a href="https://remixicon.com/" target="_blank"><i class="ri-external-link-line"></i> RemixIcon</a></p>
			<p><a href="https://particles.js.org/" target="_blank"><i class="ri-external-link-line"></i> tsParticles</a></p>
		</div>
	</div>

	<div class="line"></div>

	<h3><?= lang("ABOUT_TESTING") ?></h3>
	<div class="group">
		<div class="item">
			<p>Nicolas M.</p>
			<p>Luc G.</p>
			<p>Marc P.</p>
			<p>Eylann J.</p>
		</div>
		<div class="item">
			<p>Romain P.</p>
			<p>Lucas B.</p>
			<p>Enora P.</p>
			<p>Nassim M.</p>
		</div>
		<div class="item">
			<p>Benjamin S.</p>
			<p>Léo M.</p>
			<p>Thomas A.</p>
		</div>
	</div>

	<div class="line"></div>

	<h3><?= lang("ABOUT_LEGAL") ?></h3>
	<p>LabSupervisor Corp<br>contact@labsupervisor.fr</p>
</div>

<?php
	require($_SERVER["DOCUMENT_ROOT"] . '/include/footer.php');
?>
