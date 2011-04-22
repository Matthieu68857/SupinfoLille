<?php
	
	require_once("../inclusions/configuration.php");
	
	session_start();
	
	setcookie('idbooster', '', 0, '/', '.' . GBL_NDD);
	setcookie('pass', '', 0, '/', '.' . GBL_NDD);
	setcookie('nom', '', 0, '/', '.' . GBL_NDD);
	setcookie('prenom', '', 0, '/', '.' . GBL_NDD);
	setcookie('status', '', 0, '/', '.' . GBL_NDD);
	
	setcookie('idbooster', '', 0);
	setcookie('pass', '', 0);
	setcookie('nom', '', 0);
	setcookie('prenom', '', 0);
	setcookie('status', '', 0);
	
	session_destroy();
	
	header('location: ../connexion/connexion.php');

?>