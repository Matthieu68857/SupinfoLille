<?php

	session_start();
	
	require_once("../configuration.php");
	require_once("../auto_chargement_classes.php");
	require_once('Auth/OpenID/SReg.php');

	if (isset($_POST['idbooster'])){
	
		if(isset($_POST['save']) && !empty($_POST['save'])){
			setcookie('save', 'true', time() + 31*24*3600, '/', '.' . GBL_NDD);
		} else {
			setcookie('save', 'false', time() + 31*24*3600, '/', '.' . GBL_NDD);
		}
		
		setcookie('idbooster', $_POST['idbooster'], time() + 31*24*3600, '/', '.' . GBL_NDD);
		
		// Système de stockage : fichiers ou base de données (MySQL, SQLite, PostgreSQL...).
		$store = new Auth_OpenID_FileStore(OID_STORAGE);
		$consumer = new Auth_OpenID_Consumer($store);
		$authRequest = $consumer->begin("https://id.supinfo.com/me/" . $_POST['idbooster']);
		$sreg = Auth_OpenID_SRegRequest::build(array('fullname'));
		$authRequest->addExtension($sreg);
		$redirectURL = $authRequest->redirectURL(OID_REALM, OID_RETURN_TO);
		if ($redirectURL != null){
			header("Location: $redirectURL"); // Redirection vers l'OP
		}
		
	} else {
		header('location: ' . GBL_NDD_WWW);
	}

