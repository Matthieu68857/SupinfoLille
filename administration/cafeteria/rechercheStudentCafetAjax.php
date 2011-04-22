<?php

	require_once('../inclusions/initialisation.php');
		
	if(isset($_GET['recherche'])){
				
		$students = $BDD->select(
			"*",
			"TB_STUDENTS",
			"WHERE student_idbooster = ?",
			array($_GET['recherche'])
		);
		
		if(count($students) == 0){
			echo "<p id='recherche_vide'>Aucun étudiant n'a pu être trouvé.</p>";	
		}
		else {
			foreach($students as $student){
				echo "<p><img class='student_found' 
					title='".$student->student_idbooster."' 
					src='http://www.campus-booster.net/actorpictures/".$student->student_idbooster.".jpg'/><br /><span>Solde restant : <span id='student-solde'>" . $student->student_solde_cafeteria . "</span> €</span></p>";	
				
			}
		}
		
	
	} else {
	
	 echo "Petit souci technique...";
	
	}
		
?>