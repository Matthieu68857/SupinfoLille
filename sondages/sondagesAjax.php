<?php

	require_once('../inclusions/initialisation.php');
	
	global $BDD;
	
	$lastsondage = $BDD->select(
		"*",
		"TB_SONDAGES",
		"ORDER BY sondage_id DESC"
	);
	
	$dfin = explode("-", $lastsondage[0]->sondage_date_fin);
	$datefin = mktime(0,0,0,$dfin[1],$dfin[2],$dfin[0]);
	
	$controle = $BDD->select(
		"student_sondage_reponses",
		"TB_STUDENTS",
		"WHERE student_idbooster = ?",
		array($_SESSION['user']['idbooster'])
	);
	
	if ($datefin >= time()) {
	
		if ($_GET[action] == "changevote") {
		
			$voteid = $BDD->select(
				"student_sondage_reponses",
				"TB_STUDENTS",
				"WHERE student_idbooster = ?",
				array($_SESSION['user']['idbooster'])
			);
			
			$string = unserialize($voteid[0]->student_sondage_reponses);
			
			foreach ($string as $string2) {
		
				$BDD->update(
					"TB_SONDAGES_CHOIX",
					array("sondage_choix_votes = sondage_choix_votes - 1"),
					"sondage_choix_id = ?",
					array($string2) 
				); 
			}
		
			$BDD->update(
				"TB_STUDENTS",
				array("student_sondage_reponses = ?"),
				"student_idbooster = ?",
				array("0",$_SESSION['user']['idbooster'])
			);
		
		} else if($controle[0]->student_sondage_reponses == "0") {
		if(!isset($_POST[opt]) || $_POST[opt] == "") { header('location:sondages.php');} else {
			$data = $_POST[opt];
			$serialize = serialize($_POST[opt]);
			$student = new Student($_SESSION['user']['idbooster']);
			
			$BDD->update(
				"TB_STUDENTS",
				array("student_sondage_reponses = ?"),
				"student_idbooster = ?",
				array($serialize, $_SESSION['user']['idbooster']) 
			); 
			
			foreach ($data as $datas) {

				$BDD->update(
					"TB_SONDAGES_CHOIX",
					array("sondage_choix_votes = sondage_choix_votes + 1"),
					"sondage_choix_id = ?",
					array($datas) 
				); 
			}
			
		}
		}
	}
	
	header('location:sondages.php');
	
?>