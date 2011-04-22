<?php

/* ************ printStudentProfile() ************
 * 
 * Affiche le profile du student correspondant au booster
 * 
 */

	function printStudentProfile($p_idbooster){
	
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
	
	if($student->getFacebook()==""){
		$student->setFacebook("Aucun Facebook renseigné.");
	} else {
		$student->setFacebook("<a href='http://www.facebook.com/".$student->getFacebook()."'>".$student->getFacebook()."</a>");
	}
	if($student->getTwitter()==""){
		$student->setTwitter("Aucun Twitter renseigné.");
	} else {
		$student->setTwitter("<a href='http://twitter.com/".$student->getTwitter()."'>".$student->getTwitter()."</a>");
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
	
	echo "<h2>". $student->getPrenom() . " " . $student->getNom() ." <div>" . $student->getIdbooster() . "</div></h2>";
	
	echo '<div id="identite">
		<img src="http://www.campus-booster.net/actorpictures/' . $student->getIdbooster() . '.jpg"/>
	</div>';
				
	echo "<div id='identite2'><br/>
		<img src='../images/promo.png' title='Promotion'/> 
		<span>Promotion : <strong>" . $student->getPromo() . "</strong> </span>
			<br/>
		<img src='../images/visites.png' title='Visites'/> 
		<span>Nombre de visites : <strong>" . $student->getVisites() . "</strong> </span>
	</div>";
					
	echo '<div id="compte_infos"><br/>
	 	<p>Cliquez sur les icônes pour afficher les informations</p>
		<img src="../images/facebook.png" title="Facebook"/>
		<img src="../images/twitter.png" title="Twitter"/> 
		<img src="../images/portable.png" title="Portable"/> 
		<img src="../images/skype.png" title="Skype"/>
		<img src="../images/live.png" title="MSN"/> 
		<input type="hidden" name="Facebook" value="' . $student->getFacebook() . '"/>
		<input type="hidden" name="Twitter" value="' . $student->getTwitter() . '"/>
		<input type="hidden" name="Portable" value="' . $student->getPortable() . '"/>
		<input type="hidden" name="Skype" value="' . $student->getSkype() . '"/>
		<input type="hidden" name="MSN" value="' . $student->getMsn() . '"/>
		<p id="resultats_sociaux"></p>
	</div>';
	
	}
	
/* ************ searchStudents() ************
 * 
 * Recherche les etudiants trouves
 * 
 */
	
	function searchStudents($p_recherche){
	
		global $BDD;
	
		$students = $BDD->select(
			"student_idbooster",
			"TB_STUDENTS",
			"WHERE 
				student_idbooster LIKE CONCAT('%',CONCAT(?, '%')) OR  
				UPPER(student_nom) LIKE CONCAT('%',CONCAT(?, '%')) OR
				UPPER(student_prenom) LIKE CONCAT('%',CONCAT(?, '%')) OR
				CONCAT(CONCAT(UPPER(student_prenom),' '), UPPER(student_nom)) LIKE CONCAT('%',CONCAT(?, '%')) OR
				CONCAT(CONCAT(UPPER(student_nom),' '), UPPER(student_prenom)) LIKE CONCAT('%',CONCAT(?, '%')) OR
				student_promo = ?
			ORDER BY student_nom LIMIT 0,28",
			array($p_recherche, $p_recherche, $p_recherche, $p_recherche, $p_recherche, $p_recherche)
		);
		
		return $students;

	}

/* ************ searchAndPrintStudents() ************
 * 
 * Recherche et affiche les etudiants trouves
 * 
 */

	function searchAndPrintStudents($p_recherche, $p_initial=false){
	
		$easterEgg = 0;
	
		global $BDD;
		
		if($p_initial == true || $p_recherche == ""){
		
			$students = $BDD->select(
				"student_idbooster",
				"TB_STUDENTS",
				"ORDER BY student_visites DESC LIMIT 0,28"
			);
					
		} elseif($p_recherche == "300") {

			$easterEgg = 1;
			
		} else {
		
			$p_recherche = strtoupper($p_recherche);
										
			$students = searchStudents($p_recherche);
			
		}
		
		if(count($students) == 0){
			if($easterEgg == 1){
				echo "<img class='students_found' title='300' src='http://www.campus-booster.net/actorpictures/300.jpg'/>";
			} else {
				echo "<p id='recherche_vide'>Aucun étudiant n'a pu être trouvé.</p>";
			}
		} else {
			foreach($students as $student){
				echo "<img class='students_found' 
					title='".$student->student_idbooster."' 
					src='http://www.campus-booster.net/actorpictures/".$student->student_idbooster.".jpg'/>";	
			}
		}
	
	}

?>