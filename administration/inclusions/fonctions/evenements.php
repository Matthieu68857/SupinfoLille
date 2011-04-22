<?php

	require_once("../../inclusions/fonctions/evenements.php");


/* ************ creerEvenement() ************
 * 
 * Crée un evenement
 * 
 */

	function creerEvenement($p_titre, $p_ss_titre, $p_date, $p_description, $p_publier){
	
		global $BDD;
	
		$BDD->insert(
			"TB_EVENEMENTS",
			array("evenement_titre","evenement_ss_titre","evenement_date","evenement_description"),
			array("?","?","?","?"),
			array($p_titre, $p_ss_titre, $p_date, $p_description)
		);
		
		if($p_publier){
			publierSurTwitter(
				'Le ' . substr($p_date, 8, 2) . '/' . substr($p_date, 5, 2) . '/' . substr($p_date, 0, 4) . ' ' . $p_titre, 
				'/evenements.php', 
				'/administration/evenements.php'
			);
		}
	}

/* ************ supprimerEvenement() ************
 * 
 * Supprime un evenement
 * 
 */

	function supprimerEvenement($p_id){
	
		global $BDD;
	
		$BDD->delete(
			"TB_EVENEMENTS",
			"evenement_id = ?",
			array($p_id)
		);
		
		$BDD->delete(
			"TB_EVENEMENTS_PARTICIPATIONS",
			"evenement_id = ?",
			array($p_id)
		);
	
	}

/* ************ updateEvenement() ************
 * 
 * Met un jour un evenement
 * 
 */

	function updateEvenement($p_id, $p_titre, $p_ss_titre, $p_date, $p_description){
		
		global $BDD;
	
		$BDD->update(
			"TB_EVENEMENTS",
			array("evenement_titre = ?", "evenement_ss_titre = ?", "evenement_date = ?", "evenement_description = ?"),
			"evenement_id = ?",
			array($p_titre, $p_ss_titre, $p_date, $p_description, $p_id)
		);
					
	}
	
/* ************ printCreationEvenement() ************
 * 
 * Affiche le formulaire de creation d'event
 *
 */

	function printCreationEvenement(){
		
		echo "<form action='evenements.php' method='post'>";
		echo "<strong>Titre : </strong> <input type='text' name='titre'/> <br/><br/>";
		echo "<strong>Sous-Titre : </strong> <input type='text' name='ss_titre'/> <br/><br/>";
		echo "<strong>Date : </strong> <input type='text' name='date'/> <br/><br/>";
		if(TWI_CONSUMER_KEY != "0" && TWI_CONSUMER_SECRET != "0"){
			echo "<strong><label for='publierSurTwitter'>Twitter : </label></strong><input type='checkbox' id='publierSurTwitter' name='publierSurTwitter' checked='checked'/> <br/><br/>";
		}
		echo "<strong>Description : </strong> <br/><br/> <textarea name='description'></textarea>";
		echo "<p style='text-align:center'>";
		echo "<input type='submit' value='Créer'/><p>";
		echo "</form>";
		
	}
	
/* ************ printEditionEvenement() ************
 * 
 * Affiche le formulaire d'edition pour l'evenement en param
 *
 */

	function printEditionEvenement($p_evenement_id){
		
		global $BDD;
	
		$evenement = $BDD->select(
			"*",
			"TB_EVENEMENTS",
			"WHERE evenement_id = ?",
			array($p_evenement_id)
		);
		
		echo "<form action='evenements.php' method='post'>";
		echo "<strong>Titre : </strong> <input type='text' name='titre' value='".$evenement[0]->evenement_titre."'/> <br/><br/>";
		echo "<strong>Sous-Titre : </strong> <input type='text' name='ss_titre' value='".$evenement[0]->evenement_ss_titre."'/> <br/><br/>";
		echo "<strong>Date : </strong> <input type='text' name='date' value='".$evenement[0]->evenement_date."'/> <br/><br/>";
		echo "<strong>Description : </strong> <br/><br/> <textarea name='description'>".$evenement[0]->evenement_description."</textarea>";
		echo "<input type='hidden' name='id' value='".$evenement[0]->evenement_id."'/>";
		echo "<p style='text-align:center'><input type='submit' value='Éditer'/><p>";
		echo "</form>";
		
	}
	
/* ************ getIdDernierEvenement() ************
 * 
 * Retourne l'ID du dernier event
 * 
 * @return int id dernier event
 *
 */
	
	function getIdDernierEvenement(){
	
		global $BDD;
	
		$evenement = $BDD->select(
			"evenement_id",
			"TB_EVENEMENTS",
			"ORDER BY evenement_date DESC, evenement_id DESC LIMIT 0,1",
			array($p_evenement_id)
		);
	
		return $evenement[0]->evenement_id;	
	}

?>