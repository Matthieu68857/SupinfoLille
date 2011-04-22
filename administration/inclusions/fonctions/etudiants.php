<?php

	require_once("../../inclusions/fonctions/etudiants.php");

/* ************ initStudentPass() ************
 * 
 * Initialise le password du student en parametre
 * 
 */

	function initStudentPass($p_idbooster){
	
		$chaine = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789@";
		$nb_caract = 6;
		$passClair = "";
		for($u = 1; $u <= $nb_caract; $u++) {
    		$nb = strlen($chaine);
    		$nb = mt_rand(0,($nb-1));
    		$passClair.=$chaine[$nb];
    	}
    	
    	$pass = md5($passClair);
		
		global $BDD;
	
		$BDD->update(
			"TB_STUDENTS",
			array("student_pass = ?"),
			"student_idbooster = ?",
			array($pass, $p_idbooster)
		);
		
		return $passClair;
			
	}

/* ************ modifierStudentInfos() ************
 * 
 * Modifie les informations des students
 * 
 */

	function modifierStudentInfos($p_idbooster, $p_what, $p_new){
		
		global $BDD;
	
		$BDD->update(
			"TB_STUDENTS",
			array("student_".$p_what." = ?"),
			"student_idbooster = ?",
			array($p_new, $p_idbooster)
		);
			
	}

/* ************ printStudentProfileToEdit() ************
 * 
 * Affiche le profile du student correspondant au booster
 * 
 */

	function printStudentProfileToEdit($p_idbooster){
	
	$student = new Student($p_idbooster);
	
	echo "<h2>". $student->getPrenom() . " " . $student->getNom() ." <div id='boosterEdit'>" . $student->getIdbooster() . "</div></h2>";
	
	echo '<div id="identite">
		<img src="http://www.campus-booster.net/actorpictures/' . $student->getIdbooster() . '.jpg"/>
	</div>';
				
	echo "<div id='identite2'><br/>
		<img src='../../images/promo.png' title='Promotion'/> 
		<span>Promotion : <strong id='EditPromotion'>" . $student->getPromo() . "</strong> </span>
			<br/>
		<img src='../../images/visites.png' title='Visites'/> 
		<span>Visites : <strong id='EditVisites'>" . $student->getVisites() . "</strong> </span>
	</div>";
					
	echo '<div id="compte_infos"><br/>
	 	<p>Cliquez sur le bouton pour réinitialiser le mot de passe</p>
		<p id="initPass" style="text-align:center"><input type="button" value="Réinitialiser" title="'.$student->getIdbooster().'"/></p>
		<p id="newPass"></p>
		<p>Ajouter, enlever de l\'argent, gérer le solde</p>
		<p style="text-align:center"><input onclick="location.href=\'gererSolde.php?idbooster='.$student->getIdbooster().'\'" type="button" value="Gérer Solde"/></p>
	</div>';
	
	}

?>