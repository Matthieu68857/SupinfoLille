<?php

	require_once('../inclusions/initialisation.php');

	global $BDD;
	
	$reponses = $BDD->select(
		"student_idbooster, student_nom, student_prenom, student_sondage_reponses",
		"TB_STUDENTS",
		"ORDER BY student_sondage_reponses, student_nom, student_prenom"
	);
	
	foreach($reponses as $reponse){
		$nom = $reponse->student_nom;
		$prenom = $reponse->student_prenom;
		if(unserialize($reponse->student_sondage_reponses) != 0){
			$reponse = unserialize($reponse->student_sondage_reponses);
			$student_reponse = array($reponse[0],$nom,$prenom);
			echo $student_reponse[1] . " " . $student_reponse[2] . " : " . getReponseChoix($student_reponse[0]) . "<br/>";
		}
	}

?>