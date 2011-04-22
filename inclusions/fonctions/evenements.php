<?php

/* ************ printParticipantsEvenement() ************
 * 
 * Affiche les participants d'un evenement
 * 
 */

	function printParticipantsEvenement($p_event_id){
	
		global $BDD;
	
		$participants = $BDD->select(
			"student_idbooster",
			"TB_EVENEMENTS_PARTICIPATIONS",
			"WHERE evenement_id = ?",
			array($p_event_id)
		);
		
		if(count($participants)==0){
			echo "<em>Aucun participant pour le moment</em>";
		}
				
		foreach($participants as $participant){
			echo '<a href="etudiants.php?idbooster='.$participant->student_idbooster.'">
				<img src="http://www.campus-booster.net/actorpictures/' . $participant->student_idbooster . '.jpg"/>
			</a>';
		}
	
	}
	
/* ************ getNbParticipantsEvenement() ************
 * 
 * Renvoit le nombre de participants
 * 
 * @return string nb participants
 *
 */

	function getNbParticipantsEvenement($p_event_id){
	
		global $BDD;
	
		$participants = $BDD->select(
			"*",
			"TB_EVENEMENTS_PARTICIPATIONS",
			"WHERE evenement_id = ?",
			array($p_event_id)
		);
				
		return count($participants);
		
	}

/* ************ desinscriptionEvenement() ************
 * 
 * Desinscrit un idbooster d'un evenement
 * 
 */

	function desinscriptionEvenement($p_idbooster, $p_event_id){
	
		global $BDD;
		
		$participation = $BDD->select(
			"*",
			"TB_EVENEMENTS_PARTICIPATIONS",
			"WHERE evenement_id = ? AND student_idbooster = ?",
			array($p_event_id, $p_idbooster)
		);
		
		if(count($participation)>0){
	
			$BDD->delete(
				"TB_EVENEMENTS_PARTICIPATIONS",
				"evenement_id = ? AND student_idbooster = ?",
				array($p_event_id, $p_idbooster)
			);
		
			$BDD->update(
				"TB_EVENEMENTS",
				array("evenement_participants = evenement_participants - 1"),
				"evenement_id = ?",
				array($p_event_id)
			);
		}
	
	}

/* ************ inscriptionEvenement() ************
 * 
 * Inscrit un idbooster a un evenement
 * 
 */

	function inscriptionEvenement($p_idbooster, $p_event_id){
	
		global $BDD;
		
		$participation = $BDD->select(
			"*",
			"TB_EVENEMENTS_PARTICIPATIONS",
			"WHERE evenement_id = ? AND student_idbooster = ?",
			array($p_event_id, $p_idbooster)
		);
		
		if(count($participation)==0){
			
			$BDD->insert(
				"TB_EVENEMENTS_PARTICIPATIONS",
				array("evenement_id","student_idbooster"),
				array("?","?"),
				array($p_event_id, $p_idbooster)
			);
		
			$BDD->update(
				"TB_EVENEMENTS",
				array("evenement_participants = evenement_participants + 1"),
				"evenement_id = ?",
				array($p_event_id)
			);
		
		}
	
	}

/* ************ getActionThisEvent() ************
 * 
 * Renvoit l'action adapate pour l'utilissateur et cet evenement
 * 
 * @return string action
 *
 */

	function getActionThisEvent($p_idbooster, $p_event_id){
	
		global $BDD;
	
		$actif = $BDD->select(
			"evenement_date",
			"TB_EVENEMENTS",
			"WHERE evenement_id = ? AND evenement_date >= CURDATE()",
			array($p_event_id)
		);
		
		if(count($actif)==0){
			return "<em>Événement passé</em>";
		}
	
		$participe = $BDD->select(
			"*",
			"TB_EVENEMENTS_PARTICIPATIONS",
			"WHERE evenement_id = ? AND student_idbooster = ?",
			array($p_event_id, $p_idbooster)
		);
				
		if(count($participe)==0){
			return "<span title='".$p_event_id."' class='jeparticipe'>Je participe</span>";
		} else {
			return "<span title='".$p_event_id."' class='jeneparticipeplus'>Je ne participe plus</span>";
		}
		
	}

/* ************ getInactifsEvenements() ************
 * 
 * Renvoit tous les evenements actifs
 *
 * @return array tous les evenements actifs
 *
 */

	function getInactifsEvenements(){
	
		global $BDD;
	
		$evenements = $BDD->select(
			"evenement_id, evenement_titre, evenement_ss_titre, evenement_description, evenement_participants, DATE_FORMAT(evenement_date, '%d/%b/%Y') as evenement_date",
			"TB_EVENEMENTS",
			"WHERE evenement_date < CURDATE() ORDER BY evenement_date DESC, evenement_id DESC"
		);
	
		return $evenements;
	
	}
	
/* ************ getActifsEvenements() ************
 * 
 * Renvoit tous les evenements actifs
 *
 * @return array tous les evenements actifs
 *
 */

	function getActifsEvenements(){
	
		global $BDD;
	
		$evenements = $BDD->select(
			"evenement_id, evenement_titre, evenement_ss_titre, evenement_description, evenement_participants, DATE_FORMAT(evenement_date, '%d/%b/%Y') as evenement_date",
			"TB_EVENEMENTS",
			"WHERE evenement_date >= CURDATE() ORDER BY evenement_date DESC, evenement_id DESC"
		);
	
		return $evenements;
	
	}

/* ************ getAllEvenements() ************
 * 
 * Renvoit tous les evenements
 *
 * @return array tous les evenements
 *
 */

	function getAllEvenements(){
	
		global $BDD;
	
		$evenements = $BDD->select(
			"evenement_id, evenement_titre, evenement_ss_titre, evenement_description, evenement_participants, DATE_FORMAT(evenement_date, '%d/%b/%Y') as evenement_date",
			"TB_EVENEMENTS",
			"ORDER BY evenement_date DESC, evenement_id DESC"
		);
	
		return $evenements;
	
	}

?>