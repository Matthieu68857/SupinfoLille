<?php	session_start();	require_once("../inclusions/configuration.php");	require_once("../inclusions/auto_chargement_classes.php");	require_once("../inclusions/fonctions.php");	if(isset($_POST['idbooster']) && isset($_POST['pass']))	{		if(checkUserLogin($_POST['idbooster'], $_POST['pass'])){			$student = new Student($_POST['idbooster']);			echo $student->getPrenom()." ".$student->getNom();		} else {			echo "fail";		}	}?>