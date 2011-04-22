<?php
	
	require_once('../inclusions/initialisation.php');
	
	if($_GET['action'] == "jeparticipe"){
		inscriptionEvenement($_SESSION['user']['idbooster'], $_GET['evenement']);
		echo getActionThisEvent($_SESSION['user']['idbooster'], $_GET['evenement']);
	} elseif($_GET['action'] == "jeneparticipeplus") {
		desinscriptionEvenement($_SESSION['user']['idbooster'], $_GET['evenement']);
		echo getActionThisEvent($_SESSION['user']['idbooster'], $_GET['evenement']);
	} elseif($_GET['action'] == "participants") {
		echo getNbParticipantsEvenement($_GET['evenement']) . " participants";
	} elseif($_GET['action'] == "printparticipants") {
		printParticipantsEvenement($_GET['evenement']);
	}
	
?>