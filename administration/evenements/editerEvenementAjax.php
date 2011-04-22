<?php

	require_once('../inclusions/initialisation.php');

	if(isset($_GET['creation'])){
		printCreationEvenement();
	} else {
		printEditionEvenement($_GET['id']);
	}

?>