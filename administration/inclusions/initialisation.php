<?php
	
	session_start();
	
	// Inclusion du fichier de configuration
	require_once("../../inclusions/configuration.php");
	
	// Inclusion automatique des classes
	require_once('../../inclusions/auto_chargement_classes.php');
	
	// Ouverture de la connexion à la BDD
	$BDD = new BDD();
	
	// Inclusion des fichiers de fonctions
	require_once("fonctions/cafeteria.php");
	require_once("fonctions/documents.php");
	require_once("fonctions/droits.php");
	require_once("fonctions/entraide.php");
	require_once("fonctions/etudiants.php");
	require_once("fonctions/evenements.php");
	require_once("fonctions/main.php");
	require_once("fonctions/sondages.php");
	require_once("fonctions/sbn.php");

	/* #### Droits #### */
	
	$path = explode('/', $_SERVER['PHP_SELF']);
	$categorie = $path[count($path) - 2];
	
	// On recharge les droits à chaque page
	getCategoriesAutorisation();
	
	if(!in_array($categorie, $_SESSION['categories_admin'])){
		header("location: ../../index.php");
	}
	
?>