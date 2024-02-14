<?php
	function getParticipant($sessionId) {
		$db = dbConnect();

		// Get participant query
		$query = "SELECT us.name, us.surname, ch.title, st.state FROM user us, status st, session s, chapter ch WHERE us.id = st.iduser AND s.id = :idSession AND s.id = st.idsession AND ch.idsession = s.id AND st.idchapter = ch.id ORDER BY us.name ASC";

		// Get participant
		$queryPrep = $db->prepare($query);
		$queryPrep->bindParam(':idSession', $_SESSION["session"]);
		$queryPrep->execute();

		return($queryPrep->fetchAll(\PDO::FETCH_ASSOC));
	}
?>
