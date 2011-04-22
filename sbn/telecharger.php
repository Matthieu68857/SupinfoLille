<?php

	require_once('../inclusions/initialisation.php');

	$stage = new Stage($BDD, $_GET['stage']);
	
	if($stage->getFichier() != ""){
		telechargerDocument($stage->getFichier(), "fichiers/");
	}

?>