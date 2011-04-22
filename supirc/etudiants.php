<?php

	header('Content-Type: text/html; charset=utf-8');

	require_once("../inclusions/configuration.php");
	require_once("../inclusions/auto_chargement_classes.php");
	require_once("../inclusions/fonctions.php");

	if(isset($_POST['idbooster']) && isset($_POST['pass'])){
		if(checkUserLogin($_POST['idbooster'], $_POST['pass'])){
		 	
		 	if(isset($_POST['idStudent'])){
				printStudentProfileForIRC($_POST['idStudent']);
			} else {
				printStudentProfileForIRC($_POST['idbooster']);
			}	 	
		 	
		} else {
			echo "fail";
		}
	}
	
	function printStudentProfileForIRC($p_idbooster){
		
		$student = new Student($p_idbooster);
	
		if($p_idbooster == 300){
			$student->setPromo("R2D2");
			$student->setPrenom("Alick");
			$student->setNom("Mouriesse"); 
			$student->setPortable("666666666"); 
			$student->setMsn("dieu@hotmail.com");
			$student->setSkype("DieuEstAussiSurSkype");
			$student->setTwitter("TwitDivin");
			$student->setFacebook("AlickBook"); 
			$student->setAutorisation(5);
			$student->setVisites("-1"); 
		} 
	
		if($student->getAutorisation()==1){
			$student->setAutorisation("Étudiant");
		}  elseif($student->getAutorisation()==0){
			$student->setAutorisation("Bloqué");
		} elseif($student->getAutorisation()==5){
			$student->setAutorisation("Dieu");
		} else {
			$student->setAutorisation("Admin");
		}
	
		if($student->getFacebook()==""){
			$student->setFacebook("Aucun Facebook renseigné.");
		}
		if($student->getTwitter()==""){
			$student->setTwitter("Aucun Twitter renseigné.");
		}
		if($student->getSkype()==""){
			$student->setSkype("Aucun Skype renseigné.");
		}
		if($student->getPortable()==""){
			$student->setPortable("Aucun Portable renseigné.");
		} else {
			$student->setPortable("0".$student->getPortable());
		}
		if($student->getMsn()==""){
			$student->setMsn("Aucun MSN renseigné.");
		}
		
		echo $student->getPrenom() . " " . $student->getNom() . ";#;" . $student->getIdbooster() . ";#;" . $student->getPromo() . ";#;" . $student->getAutorisation() . ";#;" . $student->getVisites() . ";#;" . $student->getFacebook() . ";#;" . $student->getTwitter() . ";#;" . $student->getPortable() . ";#;" . $student->getSkype() . ";#;" . $student->getMsn();
	}

?>