<?php

	require_once('../inclusions/initialisation.php');
	
	checkStudentIpConnexion($_SESSION['user']['idbooster'], $_SERVER['REMOTE_ADDR']);
	printStudentConnectes();

?>