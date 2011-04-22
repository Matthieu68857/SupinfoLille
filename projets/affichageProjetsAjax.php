<?php

	require_once('../inclusions/initialisation.php');
		
	if($_GET['categorie'] == "Tous"){
		printAllProjets();
	} else {
		printProjetsOf($_GET['categorie']);
	}
	
?>