<?php

/* ************ getAllEntraides() ************
 * 
 * Renvoit toutes les questions d'entraide
 *
 * @return array toutes les questions d'entraide
 *
 */

	function getAllEntraides(){
	
		global $BDD;
	
		$entraides = $BDD->select(
			"entraide_id, entraide_question, entraide_auteur, entraide_details, entraide_resolu, DATE_FORMAT(entraide_date, '%d/%b/%Y') as entraide_date",
			"TB_ENTRAIDES",
			"ORDER BY entraide_date DESC, entraide_id DESC"
		);
	
		return $entraides;
	
	}


/* ************ getNonRepEntraides() ************
 * 
 * Renvoit toutes les questions d'entraide non repondues
 *
 * @return array toutes les questions d'entraide non repondues
 *
 */

	function getNonRepEntraides(){
	
		global $BDD;
	
		$entraides = $BDD->select(
			"entraide_id, entraide_question, entraide_auteur, entraide_details, entraide_resolu, DATE_FORMAT(entraide_date, '%d/%b/%Y') as entraide_date",
			"TB_ENTRAIDES",
			"WHERE entraide_resolu = 0 ORDER BY entraide_date DESC, entraide_id DESC"
		);
	
		return $entraides;
	
	}
	
/* ************ getRepEntraides() ************
 * 
 * Renvoit toutes les questions d'entraide repondues
 *
 * @return array toutes les questions d'entraide repondues
 *
 */

	function getRepEntraides(){
	
		global $BDD;
	
		$entraides = $BDD->select(
			"entraide_id, entraide_question, entraide_auteur, entraide_details, entraide_resolu, DATE_FORMAT(entraide_date, '%d/%b/%Y') as entraide_date",
			"TB_ENTRAIDES",
			"WHERE entraide_resolu = 1 ORDER BY entraide_date DESC, entraide_id DESC"
		);
	
		return $entraides;
	
	}
	

/* ************ getReponses() ************
 * 
 * Renvoit toutes les reponses
 *
 * @return array toutes les reponses
 *
 */

	function getReponses($entraideid){
	
		global $BDD;
	
		$reponses = $BDD->select(
			"entraide_reponse_id, entraide_id, entraide_reponse, entraide_reponse_auteur, DATE_FORMAT(entraide_reponse_date, '%d/%b/%Y') as entraide_reponse_date",
			"TB_ENTRAIDES_REPONSES",
			"WHERE entraide_id = ? ORDER BY entraide_reponse_date, entraide_reponse_id",
			array($entraideid)
		);
	
		return $reponses;
	
	}


/* ************ AddQuestion() ************
 * 
 * Ajoute une question
 *
 * @return bool reussi ou non
 *
 */

	function AddQuestion(){
	
		global $BDD;
		
		$studentpn =  $_SESSION['user']['prenom'] . " " . $_SESSION['user']['nom'];
		
		if ((isset($_POST[question]) && isset($_POST[details])) && $_POST[question] != "" && $_POST[question] != "Entrez votre Question ici...") {
	
			$BDD->insert(
				"TB_ENTRAIDES",
				array("entraide_question","entraide_auteur","entraide_date","entraide_details"),
				array("?","?","CURRENT_TIMESTAMP()","?"),
				array(htmlspecialchars(stripslashes(utf8_decode($_POST[question]))), $studentpn, htmlspecialchars(stripslashes(utf8_decode($_POST[details]))))
			);
			
			$success = true;	
		}
		else { $success = false; }
	
		return $success;
	
	}


/* ************ AddReponse() ************
 * 
 * Ajoute une reponse à une question
 *
 * @return bool reussi ou non
 *
 */

	function AddReponse(){
	
		global $BDD;
		
		$studentpn =  $_SESSION['user']['prenom'] . " " . $_SESSION['user']['nom'];
		
		if (isset($_POST[reponse]) && $_POST[reponse] != "") {
	
			$BDD->insert(
				"TB_ENTRAIDES_REPONSES",
				array("entraide_reponse","entraide_reponse_auteur","entraide_reponse_date", "entraide_id"),
				array("?","?","CURRENT_TIMESTAMP()","?"),
				array(htmlspecialchars(stripslashes(utf8_decode($_POST[reponse]))), $studentpn, $_POST[entraideid])
			);
			
			$success = true;	
		}
		else { $success = false; }
	
		return $success;
	
	}

/* ************ OkQuestion() ************
 * 
 *Verifie l'auteur et Valide une question
 *
 * 
 *
 */

	function OkQuestion(){
	
		global $BDD;
		
		$studentpn =  $_SESSION['user']['prenom'] . " " . $_SESSION['user']['nom'];
		
		$verif = $BDD->select(
			"entraide_auteur",
			"TB_ENTRAIDES",
			"WHERE entraide_id = ?",
			array($_GET[id])
		);
		
		if ($verif[0]->entraide_auteur == $studentpn) {
	
				$BDD->update(
					"TB_ENTRAIDES",
					array("entraide_resolu = 1"),
					"entraide_id = ?",
					array($_GET[id])
				);			
			
		}
	
	}

?>