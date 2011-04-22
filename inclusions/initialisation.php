<?php
	
	session_start();
	
	// Inclusion du fichier de configuration
	require_once("configuration.php");
	
	// Inclusion automatique des classes
	require_once("auto_chargement_classes.php");
	
	// Ouverture de la connexion à la BDD
	$BDD = new BDD();
	
	// Inclusion des fichiers de fonctions
	require_once("fonctions/cafeteria.php");
	require_once("fonctions/documents.php");
	require_once("fonctions/entraide.php");
	require_once("fonctions/etudiants.php");
	require_once("fonctions/evenements.php");
	require_once("fonctions/main.php");
	require_once("fonctions/moncompte.php");
	require_once("fonctions/projets.php");
	require_once("fonctions/sbn.php");
	//require_once("fonctions/sondages.php");

	/* #### Connexion / Vérification / Déconnexion #### */
	
	if(!isset($_COOKIE['loginSuccess'])){
		if(isset($_COOKIE['nom']) || isset($_COOKIE['prenom']) || isset($_COOKIE['status'])){
			header('location: ' . GBL_NDD_WWW . '/connexion/deconnexion.php');
		}
	} else if($_COOKIE['loginSuccess'] == "true" && isset($_COOKIE['idbooster']) && isset($_COOKIE['pass']) && isset($_COOKIE['nom']) 
		&& isset($_COOKIE['prenom']) && (checkUserLogin($_COOKIE['idbooster'], $_COOKIE['pass'],true) || checkGuestLogin($_COOKIE['prenom'], $_COOKIE['nom'], $_COOKIE['pass']))){
		$_SESSION['user']['idbooster'] = $_COOKIE['idbooster'];
		$_SESSION['user']['pass'] = $_COOKIE['pass'];
		$_SESSION['user']['nom'] = $_COOKIE['nom'];
		$_SESSION['user']['prenom'] = $_COOKIE['prenom'];
		//$_SESSION['user']['status'] = $_COOKIE['status'];
		if(checkGuestLogin($_SESSION['user']['prenom'], $_SESSION['user']['nom'], $_SESSION['user']['pass'])){
			setcookie('idbooster', '', 0, '/', '.' . GBL_NDD);
			setcookie('pass', '', 0, '/', '.' . GBL_NDD);
		}
		setcookie('nom', '', 0, '/', '.' . GBL_NDD);
		setcookie('prenom', '', 0, '/', '.' . GBL_NDD);
		setcookie('status', '', 0, '/', '.' . GBL_NDD);
		setcookie('loginSuccess', '', 0, '/', '.' . GBL_NDD);
	}
	
	if(isset($_SESSION['user']['idbooster']) && isset($_SESSION['user']['pass']) && isset($_SESSION['user']['nom']) 
		&& isset($_SESSION['user']['prenom']) && isset($_SESSION['user']['status'])){
		if(!checkUserLogin($_SESSION['user']['idbooster'], $_SESSION['user']['pass'], true) && !checkGuestLogin($_SESSION['user']['prenom'], $_SESSION['user']['nom'], $_SESSION['user']['pass'])){
			header('location: ' . GBL_NDD_WWW . '/connexion/deconnexion.php');
		} else {
			majVisites($_SESSION['user']['idbooster']);
			checkStudentIpConnexion($_SESSION['user']['idbooster'], $_SERVER['REMOTE_ADDR']);
		}
	} else {
		if(isset($_COOKIE['idbooster']) && isset($_COOKIE['pass'])){
			if(!checkUserLogin($_COOKIE['idbooster'], $_COOKIE['pass'], true)){
				header('location: ' . GBL_NDD_WWW . '/connexion/deconnexion.php');
			} else {
				$student = new Student($_COOKIE['idbooster']);
				$_SESSION['user']['idbooster'] = $_COOKIE['idbooster'];
				$_SESSION['user']['pass'] = $_COOKIE['pass'];
				$_SESSION['user']['nom'] = $student->getNom();
				$_SESSION['user']['prenom'] = $student->getPrenom();
				//$_SESSION['user']['status'] = $student->getAutorisation();
				majVisites($_SESSION['user']['idbooster']);
				checkStudentIpConnexion($_SESSION['user']['idbooster'], $_SERVER['REMOTE_ADDR']);
			}
		} else {
			header('location: ' . GBL_NDD_WWW . '/connexion/connexion.php');
		}
	}
	
	/* #### Droits #### */
	
	$path = explode('/', $_SERVER['PHP_SELF']);
	$categorie = $path[count($path) - 2];
	getCategoriesAutorisation();
	if(!in_array($categorie, $_SESSION['categories'])){
		header("location: " . GBL_NDD_WWW);
	}
	
	/* #### Redirection vers /sbn/ #### */
	
	if($categorie != "sbn" && isset($_COOKIE['sbn'])){
		$name = explode(".", $_SERVER['SERVER_NAME']);
		if(isset($_SESSION['user']['idbooster']) && $name[0] != "stages"){
			setcookie('sbn', '', 0, '/', '.' . GBL_NDD);
			header('location: ' . GBL_NDD_WWW . '/sbn/');
		}
	}
?>