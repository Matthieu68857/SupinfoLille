<?php

	require_once("../../inclusions/fonctions/documents.php");
	
	
/* ************ getNbMatieres() ************
 * 
 * Renvoit le nombre de matieres
 * 
 * @return int nb de matieres
 *
 */

	function getNbMatieres(){
	
		global $BDD;
	
		$NB = $BDD->select(
			"COUNT(*) AS NB",
			"TB_MATIERES"
		);
	
		return $NB[0]->NB;
	
	}

/* ************ getNbDocuments() ************
 * 
 * Renvoit le nombre de documents
 * 
 * @return int nb de documents
 *
 */

	function getNbDocuments($p_cursus){
	
		global $BDD;
	
		$NB = $BDD->select(
			"COUNT(*) AS NB",
			"TB_DOCUMENTS d JOIN TB_MATIERES m ON (d.matiere_id = m.matiere_id)",
			"WHERE m.matiere_cursus LIKE '".$p_cursus."'"
		);
	
		return $NB[0]->NB;
	
	}

/* ************ getNbTelechargements() ************
 * 
 * Renvoit le nombre de telechargements
 * 
 * @return int nb de telechargement
 *
 */

	function getNbTelechargements(){
	
		global $BDD;
	
		$NB = $BDD->select(
			"SUM(document_telechargements) AS NB",
			"TB_DOCUMENTS"
		);
	
		return $NB[0]->NB;
	
	}


/* ************ desactiverDocument() ************
 * 
 * Desactive un document de la BDD
 * 
 */

	function desactiverDocument($p_id){
	
		global $BDD;
	
		$BDD->update(
			"TB_DOCUMENTS",
			array("document_status = 0"),
			"document_id = ?",
			array($p_id)
		);
	
	}

/* ************ validerDocument() ************
 * 
 * Valide un document dans la BDD, et le range sur le serveur comme il le faut
 * 
 */

	function validerDocument($p_id, $p_chemin, $p_cursus, $p_matiere){
	
		global $BDD;
	
		$BDD->update(
			"TB_DOCUMENTS",
			array("document_status = 1"),
			"document_id = ?",
			array($p_id)
		);
		
		$origine = "../../documents/uploads/".$p_chemin;
		$direction = "../../documents/documents/".$p_cursus."/".$p_matiere."/";
		
		if(!file_exists($direction)){
			exec('mkdir ' . $direction);
		}
		
		$deplacement = "mv ".$origine." ".$direction;
						
		exec($deplacement);
	
	}

/* ************ modifierNomDocument() ************
 * 
 * Modifie le nom d'un document dans la BDD
 * 
 */

	function modifierNomDocument($p_id, $p_new){
	
		global $BDD;
	
		$BDD->update(
			"TB_DOCUMENTS",
			array("document_nom = ?"),
			"document_id = ?",
			array($p_new, $p_id)
		);
	
	}

/* ************ supprimerDocument() ************
 * 
 * Supprime un document de la BDD et du serveur
 * 
 */

	function supprimerDocument($p_id, $p_cursus){
	
		global $BDD;
	
		$document = $BDD->select(
			"*",
			"TB_DOCUMENTS",
			"WHERE document_id = ?",
			array($p_id)
		);
				
		if($document[0]->document_status == 0){
		
			$chemin = "../../documents/uploads/".$document[0]->document_chemin;
		
		} else {
		
			$chemin = "../../documents/documents/".$p_cursus."/".$document[0]->matiere_id."/".$document[0]->document_chemin;
			
		}
				
		exec("rm " . $chemin);
	
		$BDD->delete(
			"TB_DOCUMENTS",
			"document_id = ?",
			array($p_id)
		);			
	}

/* ************ ajouterMatiere() ************
 * 
 * Ajoute une matiere dans la BDD
 * 
 */

	function ajouterMatiere($p_nom, $p_nom_complet, $p_cursus){
	
		global $BDD;
	
		$BDD->insert(
			"TB_MATIERES",
			array("matiere_nom","matiere_nom_complet","matiere_cursus"),
			array("?","?","?"),
			array($p_nom, $p_nom_complet, $p_cursus)
		);
		
	}

/* ************ getAllDocuments() ************
 * 
 * Renvoit tous les documents disponnibles
 * 
 * @return array tous les documents
 *
 */

	function getAllDocuments($p_cursus, $p_page){
	
		$page = ($p_page-1)*10;
	
		global $BDD;
	
		$documents = $BDD->select(
			"d.document_id, d.document_nom, d.document_chemin, d.document_telechargements, d.document_status, d.student_id, 
			m.matiere_nom, m.matiere_cursus, m.matiere_id",
			"TB_DOCUMENTS d JOIN TB_MATIERES m ON (d.matiere_id = m.matiere_id)",
			"WHERE m.matiere_cursus LIKE '".$p_cursus."' 
			 ORDER BY d.document_status, m.matiere_cursus, m.matiere_nom, d.document_nom
			 LIMIT ".$page.",10"
		);
	
		return $documents;
	
	}

/* ************ getSourcesDocumentsAdmin() ************
 * 
 * Retourne les chemins sources de tous les documents passes en paramètres
 * 
 * @return array tableau avec les chemins de tous les documents
 */

	function getSourcesDocumentsAdmin($p_in, $p_valide = true){
		
		global $BDD;
	
		$sources = $BDD->select(
			"d.document_chemin, d.matiere_id, m.matiere_cursus",
			"TB_DOCUMENTS d JOIN TB_MATIERES m ON (d.matiere_id = m.matiere_id)",
			"WHERE d.document_id IN (".$p_in.")"
		);
		
		$chemins = array();
				
		foreach($sources as $source){
			if($p_valide){
				array_push($chemins,"../../documents/documents/".$source->matiere_cursus."/".$source->matiere_id."/".$source->document_chemin);
			} else {
				array_push($chemins,"../../documents/uploads/".$source->document_chemin);
			}
		}
		
		return $chemins;
	}
	
?>