<?php

	require_once('../inclusions/initialisation.php');

$outil = $_GET['outil'];
$borneInf = $_GET['borneInf'];
$borneSup = $_GET['borneSup'];
$methode = $_GET['methode'];
$promo = $_GET['promo'];

if($outil == "randomSujet"){
	
	sleep(1);
	echo "Sujet n°<strong style='color:red'>" . rand(intval($borneInf), intval($borneSup)) . "</strong>";

} 

elseif($outil == "randomStudent"){

	sleep(1);
	
	if($methode == "visites"){
	
		$random = $BDD->select(
			"student_idbooster, student_prenom, student_nom",
			"TB_STUDENTS",
			"WHERE student_promo = ? AND student_visites = 
				(SELECT MIN(student_visites) FROM TB_STUDENTS WHERE student_promo = ?) ORDER BY RAND() LIMIT 1",
			array($promo, $promo)
		);
	
	}
	
	elseif($methode == "random"){
	
		$random = $BDD->select(
			"student_idbooster, student_prenom, student_nom",
			"TB_STUDENTS",
			"WHERE student_promo = ? ORDER BY RAND() LIMIT 1",
			array($promo)
		);
	
	}
	
	elseif($methode == "sondage"){
	
		$random = $BDD->select(
			"student_idbooster, student_prenom, student_nom",
			"TB_STUDENTS",
			"WHERE student_promo = ? AND student_sondage_reponses = '0' ORDER BY RAND() LIMIT 1",
			array($promo)
		);
	
	}
	
	echo "<img class='stud' src='http://www.campus-booster.net/actorpictures/". $random[0]->student_idbooster .".jpg'/><br/><br/>";		
	echo $random[0]->student_prenom . " " . $random[0]->student_nom . " (" . $random[0]->student_idbooster . ")";

}

?>