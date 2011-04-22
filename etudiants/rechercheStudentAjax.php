<?php

	require_once('../inclusions/initialisation.php');
		
	if($_GET['initial'] == "true"){
	
		searchAndPrintStudents("", true);
	
	} else {
	
		searchAndPrintStudents(htmlentities($_GET['recherche'],ENT_NOQUOTES,'UTF-8'));
	
	}
		
?>