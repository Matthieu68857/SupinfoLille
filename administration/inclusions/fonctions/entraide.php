<?php

	require_once("../../inclusions/fonctions/entraide.php");
	

/* ************ printEditionEntraide() ************
 * 
 * Affiche le formulaire d'edition pour l'entraide en param
 *
 */

	function printEditionEntraide($p_entraide_id){
		
		global $BDD;
	
		$entraide = $BDD->select(
			"*",
			"TB_ENTRAIDES",
			"WHERE entraide_id = ?",
			array($p_entraide_id)
		);
		
		echo "<form action='entraide.php' method='post'>";
		echo "<strong>Question : </strong> <textarea name='question'>".utf8_encode($entraide[0]->entraide_question)."</textarea><br/><br/>";
		echo "<strong>Détails : </strong> <textarea name='details' />".$entraide[0]->entraide_details."</textarea><br/><br/>";
		echo "<strong>Date : </strong> <input type='text' name='date' value='".$entraide[0]->entraide_date."'/> <br/><br/>";
		echo "<input type='hidden' name='id' value='".$entraide[0]->entraide_id."'/>";
		echo "<p style='text-align:center'><input type='submit' value='Éditer'/><p>";
		echo "</form>";
		
	}
	
/* ************ getIdDernierEntraide() ************
 * 
 * Retourne l'ID de la derniere entraide
 * 
 * @return int id derniere entraide
 *
 */
	
	function getIdDernierEntraide(){
	
		global $BDD;
	
		$entraide = $BDD->select(
			"entraide_id",
			"TB_ENTRAIDES",
			"ORDER BY entraide_date DESC, entraide_id DESC LIMIT 0,1",
			array($p_entraide_id)
		);
	
		return $entraide[0]->entraide_id;	
	}

/* ************ creerentraide() ************
 * 
 * Crée un entraide
 * 
 */

	function creerEntraide($p_question, $p_details, $p_date){
	
		global $BDD;
	
		$BDD->insert(
			"TB_ENTRAIDES",
			array("entraide_question","entraide_details","entraide_date"),
			array("?","?","?","?"),
			array(htmlspecialchars(stripslashes(utf8_decode($p_question))), htmlspecialchars(stripslashes(utf8_decode($p_details))), $p_date)
		);
	}

/* ************ supprimerEntraide() ************
 * 
 * Supprime une entraide
 * 
 */

	function supprimerEntraide($p_id){
	
		global $BDD;
	
		$BDD->delete(
			"TB_ENTRAIDES",
			"entraide_id = ?",
			array($p_id)
		);
		
		$BDD->delete(
			"TB_ENTRAIDES_REPONSES",
			"entraide_id = ?",
			array($p_id)
		);
	
	}

/* ************ updateEntraide() ************
 * 
 * Met un jour une entraide
 * 
 */

	function updateEntraide($p_id, $p_question, $p_details, $p_date){
		
		global $BDD;
	
		$BDD->update(
			"TB_ENTRAIDES",
			array("entraide_question = ?", "entraide_details = ?", "entraide_date = ?"),
			"entraide_id = ?",
			array(htmlspecialchars(stripslashes(utf8_decode($p_question))), htmlspecialchars(stripslashes(utf8_decode($p_details))), $p_date, $p_id)
		);
					
	}
	
?>