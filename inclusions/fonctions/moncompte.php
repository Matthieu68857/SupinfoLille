<?php

/* ************ majPassword() ************
 * 
 * Met à jour le mot de passe d'un etudiant
 *
 */
 
	function majPassword($p_idbooster, $p_old_mdp, $p_new_mdp, $p_confirmation_mdp){
	
		global $BDD;
	
		if(checkUserLogin($p_idbooster, md5($p_old_mdp))){
			if($p_new_mdp == $p_confirmation_mdp){
		
				$BDD->update(
					"TB_STUDENTS",
					array("student_pass = ?"),
					"student_idbooster = ?",
					array(md5($p_new_mdp), $p_idbooster)
				);
				
				return true;
			
			} else {
				return false;
			}
		} else {
			return false;			
		}
	
	}


/* ************ majInformationsStudent() ************
 * 
 * Met à jour les informations d'un student
 *
 */
 
	function majInformationsStudent($p_idbooster, $p_facebook, $p_twitter, $p_skype, $p_msn, $p_portable){
		
		global $BDD;
		
		$BDD->update(
			"TB_STUDENTS",
			array("student_facebook = ?","student_twitter = ?","student_skype = ?","student_msn = ?","student_portable = ?"),
			"student_idbooster = ?",
			array(
				standardCharacter($p_facebook), 
				standardCharacter($p_twitter), 
				standardCharacter($p_skype), 
				standardCharacter($p_msn), 
				standardCharacter($p_portable), 
				$p_idbooster
			)
		);
	
	}

?>